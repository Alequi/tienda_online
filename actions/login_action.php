<?php

session_start();
require_once __DIR__ . '/../config/conexion.php';

$con = conectar();

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    try{
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['clave'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nombre'];
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