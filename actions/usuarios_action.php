<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../helpers/validaciones.php';

$con = conectar();

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
    $rol = $_POST['rol'] ?? 'registrado';
    $activo = isset($_POST['activoUsuario']) ? 1 : 0;
    $redirect = $_POST['redirect'] ?? 'admin';

    $validarMail = validarMailCompleto($email);
    if(!$validarMail){
        $_SESSION['error'] = "Email no válido.";
        $redirectUrl = ($redirect === 'panel') ? '../views/user/panel.php' : '../admin/adminUsuarios.php';
        header('Location: ' . $redirectUrl);
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
        $redirectUrl = ($redirect === 'panel') ? '../views/user/panel.php' : '../admin/adminUsuarios.php';
        header('Location: ' . $redirectUrl);
        exit();
        
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error al actualizar el usuario: " . $e->getMessage();
        $redirectUrl = ($redirect === 'panel') ? '../views/user/panel.php' : '../admin/adminUsuarios.php';
        header('Location: ' . $redirectUrl);
        exit();
    }
}

//Creación de usuario
if($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_GET['action'])) {
    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellidos'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'] ?? '';
    $localidad = $_POST['localidad'] ?? '';
    $provincia = $_POST['provincia'] ?? '';
    $rol = $_POST['rol'];
    $activo = isset($_POST['activoUsuario']) ? 1 : 0;
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Validaciones

    $validarMail = validarMailCompleto($email);
    if(!$validarMail){
        $_SESSION['error'] = "Email no válido.";
        header('Location: ../admin/adminUsuarios.php');
        exit();
    }

    $validarDni = validarDNIcompleto($dni);
    if(!$validarDni){
        $_SESSION['error'] = "DNI no válido.";
        header('Location: ../admin/adminUsuarios.php');
        exit();
    }

    if(strlen($_POST['password']) < 6){
        $_SESSION['error'] = "La contraseña debe tener al menos 6 caracteres.";
        header('Location: ../admin/adminUsuarios.php');
        exit();
    }
    

    try {
        $sql_insert = "INSERT INTO usuarios (dni,clave, nombre, apellidos, direccion, localidad, provincia,telefono,  email,  rol, activo) 
                       VALUES (:dni, :password, :nombre, :apellidos, :direccion, :localidad, :provincia, :telefono, :email, :rol, :activo)";
        $stmt_insert = $con->prepare($sql_insert);
        $stmt_insert->bindParam(':dni', $dni);
        $stmt_insert->bindParam(':nombre', $nombre);
        $stmt_insert->bindParam(':apellidos', $apellido);
        $stmt_insert->bindParam(':email', $email);
        $stmt_insert->bindParam(':telefono', $telefono);
        $stmt_insert->bindParam(':direccion', $direccion);
        $stmt_insert->bindParam(':localidad', $localidad);
        $stmt_insert->bindParam(':provincia', $provincia);
        $stmt_insert->bindParam(':rol', $rol);
        $stmt_insert->bindParam(':activo', $activo);
        $stmt_insert->bindParam(':password', $password);
        $stmt_insert->execute();
        
        $_SESSION['success'] = "Usuario creado correctamente.";
        header('Location: ../admin/adminUsuarios.php');
        exit();
        
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error al crear el usuario: " . $e->getMessage();
        header('Location: ../admin/adminUsuarios.php');
        exit();
    }
}

//Eliminación de usuario
if(isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id_usuario = $_GET['id'];

    try {
        $sql_delete = "DELETE FROM usuarios WHERE dni = :dni";
        $stmt_delete = $con->prepare($sql_delete);
        $stmt_delete->bindParam(':dni', $id_usuario);
        $stmt_delete->execute();
        
        $_SESSION['success'] = "Usuario eliminado correctamente.";
        header('Location: ../admin/adminUsuarios.php');
        exit();
        
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error al eliminar el usuario: " . $e->getMessage();
        header('Location: ../admin/adminUsuarios.php');
        exit();
    }
}

//Camiar contraseña de usuario desde el panel de usuario
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'change_password') {
    $id_usuario = $_POST['dni'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $redirect = $_POST['redirect'] ?? 'panel';

    // Verificar la contraseña actual
    $sql_check_password = "SELECT clave FROM usuarios WHERE dni = :dni";
    $stmt_check_password = $con->prepare($sql_check_password);
    $stmt_check_password->bindParam(':dni', $id_usuario);
    $stmt_check_password->execute();
    $usuario = $stmt_check_password->fetch(PDO::FETCH_ASSOC);

    if (!$usuario || !password_verify($current_password, $usuario['clave'])) {
        $_SESSION['error'] = "La contraseña actual es incorrecta.";
        $redirectUrl = ($redirect === 'admin') ? '../admin/adminUsuarios.php' : '../views/user/panel.php';
        header('Location: ' . $redirectUrl);
        exit();
    }

    

    if($new_password !== $confirm_password){
        $_SESSION['error'] = "Las contraseñas no coinciden.";
        $redirectUrl = ($redirect === 'admin') ? '../admin/adminUsuarios.php' : '../views/user/panel.php';
        header('Location: ' . $redirectUrl);
        exit();
    }

    if(strlen($_POST['new_password']) < 6){
        $_SESSION['error'] = "La contraseña debe tener al menos 6 caracteres.";
        $redirectUrl = ($redirect === 'admin') ? '../admin/adminUsuarios.php' : '../views/user/panel.php';
        header('Location: ' . $redirectUrl);
        exit();
    }

    $new_password = password_hash($new_password, PASSWORD_BCRYPT);

    
    try {
        $sql_update_password = "UPDATE usuarios SET clave = :new_password WHERE dni = :dni";
        $stmt_update_password = $con->prepare($sql_update_password);
        $stmt_update_password->bindParam(':new_password', $new_password);
        $stmt_update_password->bindParam(':dni', $id_usuario);
        $stmt_update_password->execute();
        
        $_SESSION['success'] = "Contraseña actualizada correctamente.";
        $redirectUrl = ($redirect === 'admin') ? '../admin/adminUsuarios.php' : '../views/user/panel.php';
        header('Location: ' . $redirectUrl);
        exit();
        
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error al actualizar la contraseña: " . $e->getMessage();
        $redirectUrl = ($redirect === 'admin') ? '../admin/adminUsuarios.php' : '../views/user/panel.php';
        header('Location: ' . $redirectUrl);
        exit();
    }
}

// Obtener todos los usuarios
$sql_usuarios = "SELECT * FROM usuarios";
$stmt_usuarios = $con->prepare($sql_usuarios);
$stmt_usuarios->execute();
$usuarios = $stmt_usuarios->fetchAll(PDO::FETCH_OBJ);

$cantidad_usuarios = count($usuarios);
?>

