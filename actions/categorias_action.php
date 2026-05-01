<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/conexion.php';

$con = conectar();

// Obtener todas las categorias

$sql_categorias = "SELECT * FROM categoria ORDER BY categoriaPadre ASC, nombre ASC";
$stmt_categorias = $con->prepare($sql_categorias);
$stmt_categorias->execute();
$categorias = $stmt_categorias->fetchAll(PDO::FETCH_OBJ);

// Edición de categoría
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'edit') {
    $id_categoria = $_POST['codigo'];
    $nombre = $_POST['nombreCategoria'];
    $activo = isset($_POST['activoCategoria']) ? 1 : 0;
    $descripcion = $_POST['descripcionCategoria'] ?? '';
    $categoriaPadre = $_POST['categoriaPadre'] ?? null;

    if ($categoriaPadre === '') {
        $categoriaPadre = null;
    }

    if ($categoriaPadre !== null) {
        $categoriaPadre = (int) $categoriaPadre;
        if ($categoriaPadre === (int) $id_categoria) {
            $_SESSION['error'] = "Una categoría no puede ser su propio padre.";
            header('Location: ../admin/adminCategoria.php');
            exit();
        }

        $sql_padre = "SELECT codigo FROM categoria WHERE codigo = :codigo";
        $stmt_padre = $con->prepare($sql_padre);
        $stmt_padre->bindParam(':codigo', $categoriaPadre, PDO::PARAM_INT);
        $stmt_padre->execute();
        if (!$stmt_padre->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION['error'] = "La categoría padre seleccionada no existe.";
            header('Location: ../admin/adminCategoria.php');
            exit();
        }
    }

    $sql_update = "UPDATE categoria SET nombre = :nombre, descripcion = :descripcion, activo = :activo, categoriaPadre = :categoriaPadre WHERE codigo = :id";
    $stmt_update = $con->prepare($sql_update);
    $stmt_update->bindParam(':nombre', $nombre);
    $stmt_update->bindParam(':activo', $activo);
    $stmt_update->bindParam(':descripcion', $descripcion);
    $stmt_update->bindParam(':id', $id_categoria);
    if ($categoriaPadre === null) {
        $stmt_update->bindValue(':categoriaPadre', null, PDO::PARAM_NULL);
    } else {
        $stmt_update->bindValue(':categoriaPadre', $categoriaPadre, PDO::PARAM_INT);
    }
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
    $categoriaPadre = $_POST['categoriaPadre'] ?? null;

    if ($categoriaPadre === '') {
        $categoriaPadre = null;
    }

    if ($categoriaPadre !== null) {
        $categoriaPadre = (int) $categoriaPadre;
        $sql_padre = "SELECT codigo FROM categoria WHERE codigo = :codigo";
        $stmt_padre = $con->prepare($sql_padre);
        $stmt_padre->bindParam(':codigo', $categoriaPadre, PDO::PARAM_INT);
        $stmt_padre->execute();
        if (!$stmt_padre->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION['error'] = "La categoría padre seleccionada no existe.";
            header('Location: ../admin/adminCategoria.php');
            exit();
        }
    }

    $sql_insert = "INSERT INTO categoria (nombre, descripcion, activo, categoriaPadre) VALUES (:nombre, :descripcion, :activo, :categoriaPadre)";
    $stmt_insert = $con->prepare($sql_insert);
    $stmt_insert->bindParam(':nombre', $nombre);
    $stmt_insert->bindParam(':activo', $activo);
    $stmt_insert->bindParam(':descripcion', $descripcion);
    if ($categoriaPadre === null) {
        $stmt_insert->bindValue(':categoriaPadre', null, PDO::PARAM_NULL);
    } else {
        $stmt_insert->bindValue(':categoriaPadre', $categoriaPadre, PDO::PARAM_INT);
    }
    $stmt_insert->execute();

    $_SESSION['success'] = "Categoría creada correctamente.";
    header('Location: ../admin/adminCategoria.php');
    exit();
}

// Eliminación de categoría
if(isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id_categoria = $_GET['id'];

    $sql_delete = "UPDATE categoria SET activo = 0 WHERE codigo = :id";
    $stmt_delete = $con->prepare($sql_delete);
    $stmt_delete->bindParam(':id', $id_categoria);
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
        $orden = $_GET['orden'] ?? '';

        $sql_hijos = "SELECT codigo FROM categoria WHERE categoriaPadre = :padre AND activo = 1";
        $stmt_hijos = $con->prepare($sql_hijos);
        $stmt_hijos->bindValue(':padre', $categoria_actual->codigo, PDO::PARAM_INT);
        $stmt_hijos->execute();
        $hijos = $stmt_hijos->fetchAll(PDO::FETCH_COLUMN);

        $categoriaIds = array_merge([$categoria_actual->codigo], $hijos);

        $orderBy = 'fecha_creacion DESC';
        if ($orden === 'precio_asc') {
            $orderBy = 'precio ASC';
        } elseif ($orden === 'precio_desc') {
            $orderBy = 'precio DESC';
        } elseif ($orden === 'nuevo') {
            $orderBy = 'fecha_creacion DESC';
        }

        $placeholders = [];
        $params = [];
        foreach ($categoriaIds as $i => $id) {
            $key = ':cat' . $i;
            $placeholders[] = $key;
            $params[$key] = (int) $id;
        }

        $sql_productos_cat = "SELECT * FROM articulos WHERE categoria IN (" . implode(',', $placeholders) . ") AND activo = 1 ORDER BY $orderBy";
        $stmt_productos_cat = $con->prepare($sql_productos_cat);
        foreach ($params as $key => $value) {
            $stmt_productos_cat->bindValue($key, $value, PDO::PARAM_INT);
        }
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