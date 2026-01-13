<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/conexion.php';

$con = conectar();

// Obtener todas las categorias

$sql_categorias = "SELECT * FROM categoria";
$stmt_categorias = $con->prepare($sql_categorias);
$stmt_categorias->execute();
$categorias = $stmt_categorias->fetchAll(PDO::FETCH_OBJ);

// Edición de categoría
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'edit') {
    $id_categoria = $_POST['codigo'];
    $nombre = $_POST['nombreCategoria'];
    $activo = isset($_POST['activoCategoria']) ? 1 : 0;
    $descripcion = $_POST['descripcionCategoria'] ?? '';

    $sql_update = "UPDATE categoria SET nombre = :nombre, descripcion = :descripcion, activo = :activo WHERE codigo = :id";
    $stmt_update = $con->prepare($sql_update);
    $stmt_update->bindParam(':nombre', $nombre);
    $stmt_update->bindParam(':activo', $activo);
    $stmt_update->bindParam(':descripcion', $descripcion);
    $stmt_update->bindParam(':id', $id_categoria);
    $stmt_update->execute();

    $_SESSION['success'] = "Categoría actualizada correctamente.";
    header('Location: ../admin/adminCategoria.php');
    exit();
}

// Creación de categoría
if($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_GET['action'])) {
    $nombre = $_POST['nombreCategoria'];
    $activo = isset($_POST['activoCategoria']) ? 1 : 0;
    $descripcion = $_POST['descripcionCategoria'] ?? '';

    $sql_insert = "INSERT INTO categoria (nombre, descripcion, activo) VALUES (:nombre, :descripcion, :activo)";
    $stmt_insert = $con->prepare($sql_insert);
    $stmt_insert->bindParam(':nombre', $nombre);
    $stmt_insert->bindParam(':activo', $activo);
    $stmt_insert->bindParam(':descripcion', $descripcion);
    $stmt_insert->execute();

    $_SESSION['success'] = "Categoría creada correctamente.";
    header('Location: ../admin/adminCategoria.php');
    exit();
}

// Eliminación de categoría
if(isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id_usuario = $_GET['id'];

    $sql_delete = "DELETE FROM categoria WHERE codigo = :id";
    $stmt_delete = $con->prepare($sql_delete);
    $stmt_delete->bindParam(':id', $id_usuario);
    $stmt_delete->execute();

    $_SESSION['success'] = "Categoría eliminada correctamente.";
    header('Location: ../admin/adminCategoria.php');
    exit();
}

$suma_categorias = count($categorias);

// Obtener datos de categoría específica y sus productos
if (isset($_GET['categoria'])) {
    $nombre_categoria = $_GET['categoria'];
    
    // Buscar la categoría por nombre (case-insensitive)
    $sql_cat = "SELECT * FROM categoria WHERE LOWER(nombre) = LOWER(:nombre) AND activo = 1";
    $stmt_cat = $con->prepare($sql_cat);
    $stmt_cat->bindParam(':nombre', $nombre_categoria);
    $stmt_cat->execute();
    $categoria_actual = $stmt_cat->fetch(PDO::FETCH_OBJ);
    
    if ($categoria_actual) {
        $titulo_categoria = $categoria_actual->nombre;
        $descripcion_categoria = $categoria_actual->descripcion ?? 'Descubre nuestra selección de productos';
        
        // Obtener productos de esta categoría
        $sql_productos_cat = "SELECT * FROM articulos WHERE categoria = :categoria AND activo = 1";
        $stmt_productos_cat = $con->prepare($sql_productos_cat);
        $stmt_productos_cat->bindParam(':categoria', $categoria_actual->codigo);
        $stmt_productos_cat->execute();
        $productos_categoria = $stmt_productos_cat->fetchAll(PDO::FETCH_OBJ);
    } else {
        // Categoría no encontrada
        $titulo_categoria = 'Categoría no encontrada';
        $descripcion_categoria = 'La categoría que buscas no existe o no está disponible.';
        $productos_categoria = [];
    }
}
?>