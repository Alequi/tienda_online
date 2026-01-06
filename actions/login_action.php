<?php

session_start();
require_once __DIR__ . '/../config/conexion.php';

$con = conectar();

$email =trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');


if($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Buscar usuario en la base de datos

    try{
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar contraseña

        if ($user && password_verify($password, $user['clave'])) {
            $_SESSION['user_id'] = $user['dni'];
            $_SESSION['user_name'] = $user['nombre'];
            $_SESSION['rol'] = $user['rol'];
            $_SESSION['email'] = $user['email'];

            // Si hay un carrito en sesión, actualizar el carrito en la base de datos

            if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {

                try{
                    $dni_usuario = $_SESSION['user_id'];
                    foreach($_SESSION['cart'] as $codigo_producto => $cantidad) {
                        $sql_cart = "INSERT INTO carritos (dni_usuario, codigo_producto, cantidad) 
                                     VALUES (:dni_usuario, :codigo_producto, :cantidad)
                                     ON DUPLICATE KEY UPDATE cantidad = cantidad + :cantidad";
                        $stmt_cart = $con->prepare($sql_cart);
                        $stmt_cart->bindParam(':dni_usuario', $dni_usuario);
                        $stmt_cart->bindParam(':codigo_producto', $codigo_producto);
                        $stmt_cart->bindParam(':cantidad', $cantidad);
                        $stmt_cart->execute();
                    }

                    $_SESSION['cart'] = []; // Limpiar el carrito en sesión después de actualizar la base de datos

                } catch (PDOException $e) {
                    // Manejar error al actualizar el carrito
                    $_SESSION['error'] = "Error al actualizar el carrito: " . $e->getMessage();
                    header("Location: ../views/error.php");
                    exit();
                }

            }

            // Redirigir al usuario a la página principal después del login exitoso

            header("Location: ../index.php");
            exit();
        } else {
            $_SESSION['error'] = "Correo electrónico o contraseña incorrectos.";
            header("Location: ../views/auth/login.php");
            exit();
        }
    } catch (PDOException $e) {
        // Manejar error de la base de datos
        $_SESSION['error'] = "Error en la base de datos: " . $e->getMessage();
        header("Location: ../views/auth/login.php");
        exit();
    }
    
}else{
    header("Location: ../views/auth/login.php");
    exit();
    }