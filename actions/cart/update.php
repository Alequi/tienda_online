<?php


session_start();
require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../../helpers/auth.php';
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

if (isLoggedIn()) {
    // Usuario logeado: actualizar BD
    $dni_usuario = $_SESSION['user_id'];
    
    try {
        // Verificar que el producto existe en el carrito
        $stmt = $con->prepare("SELECT cantidad FROM carrito WHERE dni_usuario = :dni AND codigo_producto = :codigo");
        $stmt->bindParam(':dni', $dni_usuario);
        $stmt->bindParam(':codigo', $codigo_producto);
        $stmt->execute();
        $producto_carrito = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$producto_carrito) {
            http_response_code(404);
            echo json_encode(['ok' => false, 'message' => 'Producto no encontrado en el carrito.']);
            exit();
        }
        
        switch ($action) {
            case 'remove':
                $sql = "DELETE FROM carrito WHERE dni_usuario = :dni AND codigo_producto = :codigo";
                $stmt = $con->prepare($sql);
                $stmt->bindParam(':dni', $dni_usuario);
                $stmt->bindParam(':codigo', $codigo_producto);
                $stmt->execute();
                $message = 'Producto eliminado del carrito.';
                break;
                
            case 'update':
                // Verificar stock
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
                
                // Actualizar cantidad
                $sql = "UPDATE carrito SET cantidad = :cantidad 
                        WHERE dni_usuario = :dni AND codigo_producto = :codigo";
                $stmt = $con->prepare($sql);
                $stmt->bindParam(':cantidad', $cantidad);
                $stmt->bindParam(':dni', $dni_usuario);
                $stmt->bindParam(':codigo', $codigo_producto);
                $stmt->execute();
                $message = 'Carrito actualizado correctamente.';
                break;
        }
        
        // Calcular total desde BD
        $stmt = $con->prepare("SELECT SUM(cantidad) as total FROM carrito WHERE dni_usuario = :dni");
        $stmt->bindParam(':dni', $dni_usuario);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $cart_count = (int)$result['total'];
        
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['ok' => false, 'message' => 'Error al actualizar el carrito.']);
        exit();
    }
    
} else {
    // Usuario no logeado: actualizar sesión
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    if (!isset($_SESSION['cart'][$codigo_producto])) {
        http_response_code(404);
        echo json_encode(['ok' => false, 'message' => 'Producto no encontrado en el carrito.']);
        exit();
    }
    
    switch ($action) {
        case 'remove':
            unset($_SESSION['cart'][$codigo_producto]);
            $message = 'Producto eliminado del carrito.';
            break;
            
        case 'update':
            // Verificar stock
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
    
    // Calcular total desde sesión
    $cart_count = 0;
    foreach ($_SESSION['cart'] as $qty) {
        $cart_count += (int)$qty;
    }
}

echo json_encode([
    'ok' => true, 
    'message' => $message,
    'cart_count' => $cart_count
]);
exit();
