<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/conexion.php';

$con= conectar();


//Busqueda de productos


if($_SERVER['REQUEST_METHOD']==='GET' && isset($_GET['query'])){

    $_SESSION['last_search'] = $_GET['query'];
    $query = $_GET['query'];
    $stmt = $con->prepare("SELECT * FROM articulos WHERE LOWER(nombre) LIKE :query OR LOWER(descripcion) LIKE :query");
    $stmt->bindValue(':query', '%' . strtolower($query) . '%', PDO::PARAM_STR);
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION['search_results'] = $resultados;
    header('Location: ../views/tienda/resultados_busqueda.php');
    exit();




}