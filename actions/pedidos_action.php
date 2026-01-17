<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

require_once __DIR__ . '/../config/conexion.php';

$con = conectar();

//DATOS DE PEDIDO Y USUARIO
$user_id = $_SESSION['user_id'];

$stmt = $con->prepare("SELECT * FROM pedidos WHERE dniUsuario = :dni_usuario ORDER BY idPedido DESC LIMIT 1");
$stmt->bindParam(':dni_usuario', $user_id);
$stmt->execute();
$pedido = $stmt->fetch(PDO::FETCH_ASSOC);

$subtotal_sin_iva = $pedido ? $pedido['total'] / 1.21 : 0;
$iva = $pedido ? $pedido['total'] - $subtotal_sin_iva : 0;
$total_iva = $pedido ? $pedido['total'] : 0;

// Verificar que se encontró un pedido
if ($pedido) {
    $ultimo_pedido_id = $pedido['idPedido'];
    
    //CONTENIDO DEL PEDIDO
    $stmt = $con->prepare("SELECT lp.*, a.nombre AS nombre_articulo, a.imagen AS imagen_articulo 
                          FROM lineapedido lp 
                          JOIN articulos a ON lp.codArticulo = a.codigo 
                          WHERE lp.numPedido = :num_pedido");
    $stmt->bindParam(':num_pedido', $ultimo_pedido_id); 
    $stmt->execute();
    $lineas_pedido = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $pedido = null;
    $ultimo_pedido_id = 'N/A';
    $lineas_pedido = [];
}
