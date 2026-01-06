// actions/cart/update.php
// Actualizar o eliminar un ítem del carrito vía AJAX

<?php

session_start();

require_once __DIR__ . '/../../config/conexion.php';
$con = conectar();

header('Content-Type: application/json; charset=utf-8');

$input = json_decode(file_get_contents('php://input'), true);

$codigo_producto = trim($input['codigo_producto'] ?? '');
$action = trim($input['action'] ?? '');
$cantidad = (int)($input['cantidad'] ?? 0);

// Validación de código de producto
if (empty($codigo_producto)) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'message' => 'Código de producto requerido.']);
    exit();
}

// Validación de acción
if (!in_array($action, ['update', 'remove'])) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'message' => 'Acción inválida.']);
    exit();
}

// Validación de cantidad SOLO para update
if ($action === 'update' && $cantidad <= 0) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'message' => 'Cantidad debe ser mayor a 0.']);
    exit();
}

// Inicializar carrito si no existe
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Verificar que el producto existe en el carrito
if (!isset($_SESSION['cart'][$codigo_producto])) {
    http_response_code(404);
    echo json_encode(['ok' => false, 'message' => 'Producto no encontrado en el carrito.']);
    exit();
}

// Ejecutar acción
switch ($action) {
    case 'remove':
        unset($_SESSION['cart'][$codigo_producto]);
        $message = 'Producto eliminado del carrito.';
        break;
        
    case 'update':
        // Verificar stock disponible
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
            
            if ($cantidad > $producto['stock']) {
                http_response_code(400);
                echo json_encode([
                    'ok' => false, 
                    'message' => "Stock insuficiente. Disponible: {$producto['stock']}"
                ]);
                exit();
            }
            
            $_SESSION['cart'][$codigo_producto] = $cantidad;
            $message = 'Carrito actualizado correctamente.';
            
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['ok' => false, 'message' => 'Error al verificar el stock.']);
            exit();
        }
        break;
}

 

// Calcular total de items
$cart_count = 0;
foreach ($_SESSION['cart'] as $qty) {
    $cart_count += (int)$qty;
}

echo json_encode([
    'ok' => true, 
    'message' => $message,
    'cart_count' => $cart_count
]);
exit();
