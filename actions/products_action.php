<?php

require_once __DIR__ . '/../config/conexion.php';

$con = conectar();

// Obtener productos destacados (los 8 primeros activos)

$sql = "SELECT * FROM articulos where activo = 1 LIMIT 8";
$stmt = $con->prepare($sql);
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_OBJ);

$total_productos = count($productos);

if (isset($_GET['categoria'])) {

    $categoria = $_GET['categoria'];

    // Obtener productos por categoría

    switch ($categoria) {
        case 'anillos':

            $categoria_id = 2;
            $titulo_categoria = "Anillos";
            $descripcion_categoria = "Descubre nuestra colección de anillos elegantes";
            $sql_categoria = "SELECT * FROM articulos WHERE activo = 1 AND categoria = :categoria LIMIT 8";
            break;

        case 'colgantes':
            $categoria_id = 3;
            $titulo_categoria = "Colgantes";
            $descripcion_categoria = "Descubre nuestra colección de colgantes elegantes";
            $sql_categoria = "SELECT * FROM articulos WHERE activo = 1 AND categoria = :categoria LIMIT 8";
            break;

        case 'pulseras':
            $categoria_id = 1;
            $titulo_categoria = "Pulseras";
            $descripcion_categoria = "Descubre nuestra colección de pulseras elegantes";
            $sql_categoria = "SELECT * FROM articulos WHERE activo = 1 AND categoria = :categoria LIMIT 8";
            break;

        case 'pendientes':
            $categoria_id = 4;
            $titulo_categoria = "Pendientes";
            $descripcion_categoria = "Descubre nuestra colección de pendientes elegantes";
            $sql_categoria = "SELECT * FROM articulos WHERE activo = 1 AND categoria = :categoria LIMIT 8";
            break;

        case 'regalos':
            $categoria_id = 5;
            $titulo_categoria = "Regalos";
            $descripcion_categoria = "Descubre nuestra colección de regalos elegantes";
            $sql_categoria = "SELECT * FROM articulos WHERE activo = 1 AND categoria = :categoria LIMIT 8";
            break;

        case 'novedades':
            $titulo_categoria = "Novedades";
            $descripcion_categoria = "Descubre nuestras últimas novedades en joyería";
            $sql_categoria = "SELECT * FROM articulos WHERE activo = 1 ORDER BY fecha_creacion DESC LIMIT 12";
            $stmt_categoria = $con->prepare($sql_categoria);
            $stmt_categoria->execute();
            $productos_categoria = $stmt_categoria->fetchAll(PDO::FETCH_OBJ);
            break;

        default:
            header("Location: ../../../index.php");
            exit();
    }

    if ($categoria !== 'novedades') {
            $stmt_categoria = $con->prepare($sql_categoria);
            $stmt_categoria->bindParam(':categoria', $categoria_id);
            $stmt_categoria->execute();
            $productos_categoria = $stmt_categoria->fetchAll(PDO::FETCH_OBJ);

}
}   
?>

