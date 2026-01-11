<?php

require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../helpers/validaciones.php';

$con = conectar();

//obtener todos los usuarios

$sql_usuarios = "SELECT * FROM usuarios";
$stmt_usuarios = $con->prepare($sql_usuarios);
$stmt_usuarios->execute();
$usuarios = $stmt_usuarios->fetchAll(PDO::FETCH_OBJ);

$cantidad_usuarios = count($usuarios);

//Edición de usuario
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'edit') {
    $id_usuario = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellidos'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'] ?? '';
    $localidad = $_POST['localidad'] ?? '';
    $provincia = $_POST['provincia'] ?? '';
    $rol = $_POST['rol'];
    $activo = isset($_POST['activoUsuario']) ? 1 : 0;

    $validarMail = validarMailCompleto($email);
    if(!$validarMail){
        $_SESSION['error'] = "Email no válido.";
        header('Location: ../admin/adminUsuarios.php');
        exit();
    }

    try {
        $sql_update = "UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, email = :email, telefono = :telefono, 
                       direccion = :direccion, localidad = :localidad, provincia = :provincia, rol = :rol, activo = :activo 
                       WHERE dni = :dni";
        $stmt_update = $con->prepare($sql_update);
        $stmt_update->bindParam(':nombre', $nombre);
        $stmt_update->bindParam(':apellidos', $apellido);
        $stmt_update->bindParam(':email', $email);
        $stmt_update->bindParam(':telefono', $telefono);
        $stmt_update->bindParam(':direccion', $direccion);
        $stmt_update->bindParam(':localidad', $localidad);
        $stmt_update->bindParam(':provincia', $provincia);
        $stmt_update->bindParam(':rol', $rol);
        $stmt_update->bindParam(':activo', $activo);
        $stmt_update->bindParam(':dni', $id_usuario);
        $stmt_update->execute();
        
        $_SESSION['success'] = "Usuario actualizado correctamente.";
        
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error al actualizar el usuario: " . $e->getMessage();
        header('Location: ../admin/adminUsuarios.php');
        exit();
    }

    header('Location: ../admin/adminUsuarios.php');
    exit();
}
