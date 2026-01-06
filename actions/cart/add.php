<?php

session_start();
require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../helpers/cart_helper.php';
$con = conectar();

header('Content-Type: application/json; charset=utf-8');

// Leer datos JSON de la solicitud

$input = json_decode(file_get_contents('php://input'), true);

// Validar datos de entrada

$codigo_producto = isset($input['codigo_producto']) ? trim($input['codigo_producto']) : "";
$cantidad = isset($input['cantidad']) ? (int)$input['cantidad'] : 1;

// Validaciones básicas

if (empty($codigo_producto) || $cantidad < 1) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'message' => 'Datos inválidos.']);
    exit();
}

// Verificar que el producto existe y tiene stock
try {
    $stmt = $con->prepare("SELECT stock FROM articulos WHERE codigo = :codigo AND activo = 1");
    $stmt->bindParam(':codigo', $codigo_producto);
    $stmt->execute();
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$producto) {
        http_response_code(404);
        echo json_encode(['ok' => false, 'message' => 'Producto no encontrado.']);
        exit();
    }
    
    // Verificar stock disponible
    $cantidad_actual = isset($_SESSION['cart'][$codigo_producto]) ? $_SESSION['cart'][$codigo_producto] : 0;
    if (($cantidad_actual + $cantidad) > $producto['stock']) {
        http_response_code(400);
        echo json_encode([
            'ok' => false, 
            'message' => 'Stock insuficiente. Solo quedan ' . ($producto['stock'] - $cantidad_actual) . ' disponibles.'
        ]);
        exit();
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'message' => 'Error al verificar el producto.']);
    exit();
}

if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Si el usuario está logueado, actualizar el carrito en la base de datos

if(isLoggedIn()) {

    $dni_usuario = $_SESSION['user_id'];
    try{

        // Insertar o actualizar el carrito en la base de datos

        $sql = "INSERT INTO carrito (dni_usuario, codigo_producto, cantidad) 
                VALUES (:dni_usuario, :codigo_producto, :cantidad)
                ON DUPLICATE KEY UPDATE cantidad = cantidad + :cantidad";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':dni_usuario', $dni_usuario);
        $stmt->bindParam(':codigo_producto', $codigo_producto);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->execute();

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['ok' => false, 'message' => 'Error al actualizar el carrito en la base de datos.']);
        exit();

    } 


}else{
    // Usuario no logueado, actualizar carrito en sesión

    if (isset($_SESSION['cart'][$codigo_producto])) {
    $_SESSION['cart'][$codigo_producto] += $cantidad;
} else {
    $_SESSION['cart'][$codigo_producto] = $cantidad;
}

}

// Obtener contador actualizado usando el helper
$cart_count = getCartCount();

// Responder con éxito
echo json_encode([
    'ok' => true,
    'message' => 'Producto agregado al carrito.',
    'cart_count' => $cart_count
]);
exit();

