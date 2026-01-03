<?php

require_once __DIR__ . '/../config/conexion.php';

$con = conectar();

$sql = "SELECT * FROM articulos where activo = 1 LIMIT 8";
$stmt = $con->prepare($sql);
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_OBJ);
?>

 