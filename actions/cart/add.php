<?php

session_start();
require_once __DIR__ . '/../../config/conexion.php';
$con = conectar();

header('Content-Type: application/json; charset=utf-8');

$input = json_decode(file_get_contents('php://input'), true);

$codigo_producto = isset($input['codigo_producto']) ? trim($input['codigo_producto']) : "";
$cantidad = isset($input['cantidad']) ? (int)$input['cantidad'] : 1;

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

if (isset($_SESSION['cart'][$codigo_producto])) {
    $_SESSION['cart'][$codigo_producto] += $cantidad;
} else {
    $_SESSION['cart'][$codigo_producto] = $cantidad;
}

$cart_count = 0;
foreach ($_SESSION['cart'] as $qty) {
    $cart_count += (int)$qty;
}

echo json_encode([
    'ok' => true,
    'message' => 'Producto agregado al carrito.',
    'cart_count' => $cart_count
]);
exit();

