<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

// Evitar cualquier output antes del JSON
ob_start();

require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ .' /../cart/view.php';
require_once __DIR__ . '/../../helpers/cart_helper.php';

// Limpiar cualquier output generado
ob_end_clean();

// Asegurar que la respuesta sea JSON
header('Content-Type: application/json');

$con = conectar();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isLoggedIn()) {
        http_response_code(401);
        echo json_encode(['success' => false, 'error' => 'Debes iniciar sesión para realizar un pedido.']);
        exit();
    }
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        $payment_method_id = $data['payment_method_id'] ?? '';
        
        if(empty($payment_method_id)) {
            echo json_encode(['success' => false, 'error' => 'Método de pago inválido']);
            exit();
        }
        
        // Validar que tengamos el total
        if(!isset($total_con_envio) || $total_con_envio <= 0) {
            echo json_encode(['success' => false, 'error' => 'Error al calcular el total del pedido']);
            exit();
        }
        
        $total_amount = $total_con_envio;
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => 'Error en los datos: ' . $e->getMessage()]);
        exit();
    }

    \Stripe\Stripe::setApiKey('sk_test_51Spu8gPfmsSFGJXZ5NU8HF0w9qb5E7yB3dfhESALTK2X7gbQ6FRhaKJzfSxOtZWLZbC4b6CbnImpNZFnM8ouIGn600R4Cp8VDt');
    
    try {
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $total_amount * 100,
            'currency' => 'eur',
            'payment_method' => $payment_method_id,
            'confirm' => true,
            'return_url' => 'http://localhost/tienda_online/views/tienda/checkout_success.php',
        ]);

        // CREAR PEDIDO EN LA BASE DE DATOS
        try{
            $user_id = $_SESSION['user_id'];
            $cart_items = getCartItems();

            $con->beginTransaction();

        // Insertar en tabla pedidos
        $fecha_pedido = date('Y-m-d');
        $stmt = $con->prepare("INSERT INTO pedidos (fecha, total, dniUsuario) VALUES (:fecha, :total, :dni_usuario)");
        $stmt->bindParam(':fecha', $fecha_pedido);
        $stmt->bindParam(':total', $total_amount);
        $stmt->bindParam(':dni_usuario', $user_id);
        $stmt->execute();

        $pedido_id = $con->lastInsertId();

        // Insertar en tabla lineapedido
        $stmt = $con->prepare("INSERT INTO lineapedido (numPedido, numLinea, codArticulo, cantidad, precio, descuento) VALUES (:numPedido, :numLinea, :codigoArticulo, :cantidad, :precio, :descuento)");

        $num_linea = 1;
        foreach($cart_items as $item){

            $codArticulo = $item['codigo_producto'];
            $cantidad = $item['cantidad'];

            // Obtener precio del producto
            $stmt_product = $con->prepare("SELECT precio, precio_anterior FROM articulos WHERE codigo = :codigo");
            $stmt_product->bindParam(':codigo', $codArticulo);
            $stmt_product->execute();
            $product = $stmt_product->fetch(PDO::FETCH_ASSOC);

            $precio = $product['precio'];
            $descuento = $product['precio_anterior'] ? $product['precio_anterior'] - $product['precio'] : 0;

            // Insertar línea de pedido
            $stmt->bindParam(':numPedido', $pedido_id);
            $stmt->bindParam(':numLinea', $num_linea);
            $stmt->bindParam(':codigoArticulo', $codArticulo);
            $stmt->bindParam(':cantidad', $cantidad);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':descuento', $descuento);
            $stmt->execute();   
            
            $num_linea++;   
            
            //ACTUALIZAR STOCK
            $stmt_update_stock = $con->prepare("UPDATE articulos SET stock = stock - :cantidad WHERE codigo = :codigo");
            $stmt_update_stock->bindParam(':cantidad', $cantidad);
            $stmt_update_stock->bindParam(':codigo', $codArticulo);
            $stmt_update_stock->execute();

            //ELIMINAR DEL CARRITO
            $stmt_delete_cart = $con->prepare("DELETE FROM carrito WHERE dni_usuario = :dni AND codigo_producto = :codigo");
            $stmt_delete_cart->bindParam(':dni', $user_id);
            $stmt_delete_cart->bindParam(':codigo', $codArticulo);
            $stmt_delete_cart->execute();

        }

        // Confirmar transacción
        $con->commit();

        // Respuesta exitosa
        echo json_encode(['success' => true]);
        exit();

    } catch (PDOException $e) {
        $con->rollBack();
        echo json_encode(['success' => false, 'error' => 'Error al procesar el pedido: ' . $e->getMessage()]);
        exit();
    }

    } catch (\Stripe\Exception\ApiErrorException $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        exit();
    }
}