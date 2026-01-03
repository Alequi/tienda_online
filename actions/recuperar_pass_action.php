<?php

session_start();
require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../helpers/validaciones.php';

$con = conectar();

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $dni = strtoupper(trim($_POST['dni'] ?? ''));
    $email = trim($_POST['email'] ?? '');

    if(!validarDNIcompleto($dni)) {
        $_SESSION['error_recuperar_pass'] = "DNI no válido.";
        header("Location: ../views/auth/recuperar_pass.php");
        exit();
    }

    if(!validarMailCompleto($email)) {
        $_SESSION['error_recuperar_pass'] = "Correo electrónico no válido.";
        header("Location: ../views/auth/recuperar_pass.php");
        exit();
    }

    $sql  = "SELECT * FROM usuarios WHERE dni = :dni AND email = :email";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':dni', $dni);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$usuario) {
        $_SESSION['error_recuperar_pass'] = "No se encontró ningún usuario con el DNI y correo electrónico proporcionados.";
        header("Location: ../views/auth/recuperar_pass.php");
        exit();
    }

    $password_temporal = bin2hex(random_bytes(4)); // Genera una contraseña temporal de 8 caracteres criptográficamente segura
    $password_hashed = password_hash($password_temporal, PASSWORD_DEFAULT);

    $sql_update = "UPDATE usuarios SET clave = :password WHERE dni = :dni";
    $stmt_update = $con->prepare($sql_update);
    $stmt_update->bindParam(':password', $password_hashed);
    $stmt_update->bindParam(':dni', $dni);
    $stmt_update->execute();

    if($stmt_update->rowCount() > 0) {
        
        $_SESSION['success_recuperar_pass'] = "Tu contraseña temporal es: $password_temporal. Por favor, cámbiala después de iniciar sesión.";
        header("Location: ../views/auth/login.php");
        exit();
    } else {
        $_SESSION['error_recuperar_pass'] = "Error al actualizar la contraseña. Por favor, inténtalo de nuevo.";
        header("Location: ../views/auth/recuperar_pass.php");
        exit();
    }


}else {
    header("Location: ../views/auth/recuperar_pass.php");
    exit();
}