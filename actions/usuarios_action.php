<?php

require_once __DIR__ . '/../config/conexion.php';

$con = conectar();

//obtener todos los usuarios

$sql_usuarios = "SELECT * FROM usuarios";
$stmt_usuarios = $con->prepare($sql_usuarios);
$stmt_usuarios->execute();
$usuarios = $stmt_usuarios->fetchAll(PDO::FETCH_OBJ);

$cantidad_usuarios = count($usuarios);

//Edición de usuario

