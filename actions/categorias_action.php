<?php

require_once __DIR__ . '/../config/conexion.php';

$con = conectar();

// Obtener todas las categorias

$sql_categorias = "SELECT * FROM categoria";
$stmt_categorias = $con->prepare($sql_categorias);
$stmt_categorias->execute();
$categorias = $stmt_categorias->fetchAll(PDO::FETCH_OBJ);
