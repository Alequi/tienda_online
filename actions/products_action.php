<?php

require_once __DIR__ . '/../config/conexion.php';

$con = conectar();

// Obtener productos destacados (los 8 primeros activos)

$sql = "SELECT * FROM articulos where activo = 1 LIMIT 8";
$stmt = $con->prepare($sql);
$stmt->execute();
$productos_destacados = $stmt->fetchAll(PDO::FETCH_OBJ);

// Configuración de paginación para admin
$registros_por_pagina = 5;
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$pagina_actual = max(1, $pagina_actual);
$offset = ($pagina_actual - 1) * $registros_por_pagina;

// Obtener total de productos
$sql_count = "SELECT COUNT(*) as total FROM articulos";
$stmt_count = $con->prepare($sql_count);
$stmt_count->execute();
$total_productos = $stmt_count->fetch(PDO::FETCH_OBJ)->total;
$total_paginas = ceil($total_productos / $registros_por_pagina);

// Obtener productos con paginación
$sql_productos = "SELECT * FROM articulos LIMIT :limit OFFSET :offset";
$stmt_productos = $con->prepare($sql_productos);
$stmt_productos->bindValue(':limit', $registros_por_pagina, PDO::PARAM_INT);
$stmt_productos->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt_productos->execute();
$productos = $stmt_productos->fetchAll(PDO::FETCH_OBJ);

$sql_categorias_count = "SELECT * FROM categoria";
$stmt_categorias = $con->prepare($sql_categorias_count);
$stmt_categorias->execute();
$total_categorias = $stmt_categorias->fetchAll(PDO::FETCH_OBJ);

$suma_categorias = count($total_categorias);





