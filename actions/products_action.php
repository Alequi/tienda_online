<?php

require_once __DIR__ . '/../config/conexion.php';

$con = conectar();

// Obtener productos destacados (los 8 primeros activos)

$sql = "SELECT * FROM articulos where activo = 1 LIMIT 8";
$stmt = $con->prepare($sql);
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_OBJ);

$total_productos = count($productos);

$sql_categorias_count = "SELECT * FROM categoria";
$stmt_categorias = $con->prepare($sql_categorias_count);
$stmt_categorias->execute();
$total_categorias = $stmt_categorias->fetchAll(PDO::FETCH_OBJ);

$suma_categorias = count($total_categorias);





