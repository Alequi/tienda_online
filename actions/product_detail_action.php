<?php

require_once __DIR__ . '/../config/conexion.php';
$con = conectar();

if (!isset($_GET['codigo'])) {
    $_SESSION['error'] = "Código de producto no proporcionado.";
    header("Location: ../views/error.php");
    exit();
}

$codigo = $_GET['codigo'];

try {
    $sql = "SELECT * FROM articulos WHERE activo = 1 AND codigo = :codigo";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':codigo', $codigo);
    $stmt->execute();
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$producto) {
        header("Location: ../views/error.php");
        exit();
    }
} catch (PDOException $e) {
    $_SESSION['error'] = "Error en la base de datos: " . $e->getMessage();
    header("Location: ../views/error.php");
    exit();
}
?>



