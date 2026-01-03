<?php

session_start();

require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../helpers/validaciones.php';
$con=conectar();

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $nombre = trim($_POST['nombre'] ?? '');
    $apellidos = trim($_POST['apellidos'] ?? '');
    $dni = trim($_POST['dni'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $localidad = trim($_POST['localidad'] ?? '');
    $provincia = trim($_POST['provincia'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $password_confirm = $_POST['password_confirm'] ?? '';

    
    $validarDni = validarDNIcompleto($dni);

    $validarMail = validarMailCompleto($email);

    if($password !== password_hash($password_confirm, PASSWORD_BCRYPT)){
        $_SESSION['error'] = "Las contraseñas no coinciden.";
        header('Location: ../views/error.php');
        exit();
    }


    if(!$validarDni){
        $_SESSION['error'] = "DNI no válido.";
        header('Location: ../views/error.php');
        exit();
    }

    if(!$validarMail){
        $_SESSION['error'] = "Email no válido.";
        header('Location: ../views/error.php');
        exit();
    }

    try {
        $sql = "INSERT INTO usuarios (nombre, apellidos, dni, direccion, localidad, provincia, telefono, email, clave, rol) 
                VALUES (:nombre, :apellidos, :dni, :direccion, :localidad, :provincia, :telefono, :email, :clave, :rol)";
        
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':localidad', $localidad);
        $stmt->bindParam(':provincia', $provincia);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':clave', $password);
        $rol = 'registrado';
        $stmt->bindParam(':rol', $rol);
        
        if($stmt->execute()){
            $_SESSION['success'] = "Registro exitoso. Ahora puedes iniciar sesión.";
            header('Location: ../views/auth/login.php');
            exit();
        } else {
            $_SESSION['error'] = "Error al registrar el usuario.";
            header('Location: ../views/error.php');
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error en la base de datos: " . $e->getMessage();
        header('Location: ../views/error.php');
        exit();
    }

}