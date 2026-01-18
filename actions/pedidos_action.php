<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../helpers/auth.php';

// Verificar que el usuario esté logueado (todos los usuarios pueden ver sus propios pedidos)
requireLogin();

$con = conectar();

//VER PEDIDOS DE USUARIO PARTICULAR EN PANEL DE USUARIO
$dni = $_SESSION['user_id'];
$stmt_user_pedidos = $con->prepare("SELECT * FROM pedidos WHERE dniUsuario = :dni_usuario ORDER BY fecha DESC");
$stmt_user_pedidos->bindParam(':dni_usuario', $dni);
$stmt_user_pedidos->execute();
$pedidos_usuario = $stmt_user_pedidos->fetchAll(PDO::FETCH_ASSOC);

//DETALLES DE PEDIDOS DE USUARIO PARTICULAR
$stmt_detalles_user = "SELECT lp.numPedido, lp.cantidad, a.nombre, a.precio 
                  FROM lineapedido lp 
                  JOIN articulos a ON lp.codArticulo = a.codigo 
                  ORDER BY lp.numPedido";
$lineas_result_user = $con->query($stmt_detalles_user)->fetchAll(PDO::FETCH_ASSOC); 
$lineas_por_pedido_user = [];
foreach ($lineas_result_user as $linea) {
    $numPedido = $linea['numPedido'];
    if (!isset($lineas_por_pedido_user[$numPedido])) {
        $lineas_por_pedido_user[$numPedido] = [];
    }
    $lineas_por_pedido_user[$numPedido][] = $linea;
}


//NUMERO TOTAL DE PEDIDOS REALIZADOS (Solo para Admin/Editor)
if (isAdmin() || isEditor()) {
    $stmt = "SELECT p.*, u.nombre FROM pedidos p JOIN usuarios u ON p.dniUsuario = u.dni ORDER BY p.fecha DESC";
    $total_pedidos = $con->query($stmt)->rowCount();
    $pedidos = $con->query($stmt)->fetchAll(PDO::FETCH_ASSOC);

    //VER DETALLES DE UN PEDIDO (para panel admin)
    $stmt_detalles = "SELECT lp.numPedido, lp.cantidad, a.nombre, a.precio 
                      FROM lineapedido lp 
                      JOIN articulos a ON lp.codArticulo = a.codigo 
                      ORDER BY lp.numPedido";
    $lineas_result = $con->query($stmt_detalles)->fetchAll(PDO::FETCH_ASSOC);

    $lineas_por_pedido = [];
    foreach ($lineas_result as $linea) {
        $numPedido = $linea['numPedido'];
        if (!isset($lineas_por_pedido[$numPedido])) {
            $lineas_por_pedido[$numPedido] = [];
        }
        $lineas_por_pedido[$numPedido][] = $linea;
    }
}



//DATOS DE PEDIDO Y USUARIO
$user_id = $_SESSION['user_id'];

$stmt = $con->prepare("SELECT * FROM pedidos WHERE dniUsuario = :dni_usuario ORDER BY idPedido DESC LIMIT 1");
$stmt->bindParam(':dni_usuario', $user_id);
$stmt->execute();
$pedido = $stmt->fetch(PDO::FETCH_ASSOC);

// Inicializar variables solo si hay pedido
if ($pedido) {
    $envio = ($pedido['total'] >= 50.0) ? 0.0 : 4.95;
    $total_con_envio = $pedido['total'];
    $subtotal_sin_iva = $total_con_envio / 1.21;
    $iva = $total_con_envio - $subtotal_sin_iva;
    $total_iva = $total_con_envio;
} else {
    $envio = 0;
    $total_con_envio = 0;
    $subtotal_sin_iva = 0;
    $iva = 0;
    $total_iva = 0;
}


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

// PROCESAR ACTUALIZACIÓN DE ESTADO DEL PEDIDO (Solo Admin/Editor)
if (isset($_GET['action']) && $_GET['action'] === 'updateEstado' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Verificar permisos de admin o editor
    if (!isAdmin() && !isEditor()) {
        $_SESSION['error'] = 'No tienes permisos para realizar esta acción';
        header('Location: ../views/user/panel.php');
        exit();
    }
    
    $idPedido = $_POST['idPedido'] ?? null;
    $estadoPedido = $_POST['estadoPedido'] ?? null;
    
    if ($idPedido && $estadoPedido) {
        try {
            $stmt_update = $con->prepare("UPDATE pedidos SET estado = :estado WHERE idPedido = :id_pedido");
            $stmt_update->bindParam(':estado', $estadoPedido);
            $stmt_update->bindParam(':id_pedido', $idPedido);
            
            if ($stmt_update->execute()) {
                $_SESSION['success'] = 'Estado del pedido actualizado correctamente';
            } else {
                $_SESSION['error'] = 'Error al actualizar el estado del pedido';
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Error: ' . $e->getMessage();
        }
    } else {
        $_SESSION['error'] = 'Datos incompletos para actualizar el pedido';
    }
    
    header('Location: ../admin/adminPedidos.php');
    exit();
}
?>
