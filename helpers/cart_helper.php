<?php

// Asegurarse de que auth.php está incluido para usar isLoggedIn()
require_once __DIR__ . '/auth.php';

/**
 * Obtiene el número total de items en el carrito
 * Lee desde BD si el usuario está logeado, desde sesión si no
 */
function getCartCount() {
    $cart_count = 0;
    
    if (isLoggedIn()) {
        // Usuario logeado: contar desde BD
        $dni_usuario = $_SESSION['user_id'];
        try {
            require_once __DIR__ . '/../config/conexion.php';
            $con = conectar();
            $stmt = $con->prepare("SELECT SUM(cantidad) as total FROM carrito WHERE dni_usuario = :dni");
            $stmt->bindParam(':dni', $dni_usuario);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $cart_count = (int)($result['total'] ?? 0);
        } catch (PDOException $e) {
            $cart_count = 0;
        }
    } else {
        // Usuario no logeado: contar desde sesión
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $qty) {
                $cart_count += (int)$qty;
            }
        }
    }
    
    return $cart_count;
}
