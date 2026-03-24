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
    $password_plano = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    // Validar campos obligatorios
    if(empty($nombre) || empty($apellidos) || empty($dni) || empty($email) || empty($telefono) || empty($password_plano)){
        $_SESSION['error'] = "Todos los campos obligatorios deben estar rellenos.";
        header('Location: ../views/auth/registro.php');
        exit();
    }

    // Validar que nombre y apellidos solo contengan letras y espacios
    if(!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]+$/', $nombre)){
        $_SESSION['error'] = "El nombre solo puede contener letras y espacios.";
        header('Location: ../views/auth/registro.php');
        exit();
    }

    if(!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]+$/', $apellidos)){
        $_SESSION['error'] = "Los apellidos solo pueden contener letras y espacios.";
        header('Location: ../views/auth/registro.php');
        exit();
    }

    $validarDni = validarDNIcompleto($dni);
    $validarMail = filter_var($email, FILTER_VALIDATE_EMAIL);

    if($password_plano !== $password_confirm){
        $_SESSION['error'] = "Las contraseñas no coinciden.";
        header('Location: ../views/auth/registro.php');
        exit();
    }

    //Validar que la contraseña tenga al menos 8 caracteres
    if(strlen($password_plano) < 8){
        $_SESSION['error'] = "La contraseña debe tener al menos 8 caracteres.";
        header('Location: ../views/auth/registro.php');
        exit();
    }

    //Validar que el teléfono tenga solo números y tenga una longitud de 9 dígitos
    if(!preg_match('/^\d{9}$/', $telefono)){
        $_SESSION['error'] = "El teléfono debe tener 9 dígitos y solo contener números.";
        header('Location: ../views/auth/registro.php');
        exit();
    }

    if(!$validarDni){
        $_SESSION['error'] = "DNI no válido.";
        header('Location: ../views/auth/registro.php');
        exit();
    }

    if(!$validarMail){
        $_SESSION['error'] = "El formato del email no es válido.";
        header('Location: ../views/auth/registro.php');
        exit();
    }

    // Calcular hash solo tras superar todas las validaciones
    $password = password_hash($password_plano, PASSWORD_BCRYPT);

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
        if ($e->getCode() === '23000') {
            // Entrada duplicada: DNI o email ya registrado
            if (strpos($e->getMessage(), 'dni') !== false) {
                $_SESSION['error'] = "El DNI introducido ya está registrado.";
            } elseif (strpos($e->getMessage(), 'email') !== false) {
                $_SESSION['error'] = "El email introducido ya está registrado.";
            } else {
                $_SESSION['error'] = "Ya existe una cuenta con estos datos.";
            }
            header('Location: ../views/auth/registro.php');
        } else {
            $_SESSION['error'] = "Error inesperado al registrar el usuario. Inténtalo de nuevo.";
            header('Location: ../views/error.php');
        }
        exit();
    }

}