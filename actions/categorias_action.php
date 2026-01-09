<?php

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

    header('Location: ../admin/adminCategoria.php');
    exit();
}

// Eliminación de categoría
if(isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id_categoria = $_GET['id'];

    $sql_delete = "DELETE FROM categoria WHERE codigo = :id";
    $stmt_delete = $con->prepare($sql_delete);
    $stmt_delete->bindParam(':id', $id_categoria);
    $stmt_delete->execute();

    header('Location: ../admin/adminCategoria.php');
    exit();
}