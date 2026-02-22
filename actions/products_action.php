<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/conexion.php';


$con = conectar();

$sql_productos_index = "SELECT * FROM articulos WHERE activo = 1 order by fecha_creacion DESC LIMIT 10";
$stmt_productos_index = $con->prepare($sql_productos_index);
$stmt_productos_index->execute();
$productos_index = $stmt_productos_index->fetchAll(PDO::FETCH_OBJ);


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

// Alta nuevo producto

if($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_GET['action'])) {
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];
    $precio_anterior = $_POST['precio_anterior'] ?? null;
    $stock = $_POST['stock'] ?? null;
    $descripcion = $_POST['descripcion'] ?? '';
    $activo = isset($_POST['activo']) ? 1 : 0;
    $imagen = null;


    //Subir imagen
    if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = $_FILES['imagen']['name'];
        $tipoArchivo = $_FILES['imagen']['type'];
        $tamanioArchivo = $_FILES['imagen']['size'];
        $rutaTemporal = $_FILES['imagen']['tmp_name'];
        $carpetaDestino = __DIR__ . '/../public/assets/img/';

        // Validaciones de la imagen

        // Verificar que el archivo es una imagen válida
        $infoImagen = getimagesize($rutaTemporal);
        if($infoImagen === false) {
            $_SESSION['error'] = "El archivo subido no es una imagen válida.";
            header('Location: ../admin/adminProductos.php');
            exit();
        }
        // Verificar tamaño máximo (10MB)
        if ($tamanioArchivo > 10 * 1024 * 1024) { // 10MB
            $_SESSION['error'] = "El tamaño de la imagen no debe exceder los 10MB.";
            header('Location: ../admin/adminProductos.php');
            exit();
        }
        // Verificar dimensiones máximas (1024x1024 píxeles)
        $ancho = $infoImagen[0];
        $alto = $infoImagen[1];
        $mime = $infoImagen['mime'];

        if ($ancho > 1024 || $alto > 1024) {
            $_SESSION['error'] = "Las dimensiones de la imagen no deben exceder los 1024x1024 píxeles.";
            header('Location: ../admin/adminProductos.php');
            exit();
        }
        // Verificar tipo de archivo permitido
        $mimesPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($mime, $mimesPermitidos)) {
            $_SESSION['error'] = "Solo se permiten imágenes en formato JPEG, PNG o GIF.";
            header('Location: ../admin/adminProductos.php');
            exit();
        }
        // Mover el archivo a la carpeta destino
        move_uploaded_file($rutaTemporal, $carpetaDestino . $nombreArchivo);
        $imagen = $nombreArchivo;
    }

    // Validar que se haya subido una imagen (la imagen es obligatoria para crear un producto)
    if(empty($imagen)) {
        $_SESSION['error'] = "Debe seleccionar una imagen para el producto.";
        header('Location: ../admin/adminProductos.php');
        exit();
    }

    try {
        $sql_insert = "INSERT INTO articulos (codigo, nombre, descripcion, categoria, stock, precio, imagen, precio_anterior, activo) 
                       VALUES (:codigo, :nombre, :descripcion, :categoria, :stock, :precio, :imagen, :precio_anterior, :activo)";
        $stmt_insert = $con->prepare($sql_insert);
        $stmt_insert->bindParam(':codigo', $codigo);
        $stmt_insert->bindParam(':nombre', $nombre);
        $stmt_insert->bindParam(':descripcion', $descripcion);
        $stmt_insert->bindParam(':categoria', $categoria);
        $stmt_insert->bindParam(':stock', $stock);
        $stmt_insert->bindParam(':precio', $precio);
        $stmt_insert->bindParam(':imagen', $imagen);
        $stmt_insert->bindParam(':precio_anterior', $precio_anterior);
        $stmt_insert->bindParam(':activo', $activo);
        $stmt_insert->execute();
        
        $_SESSION['success'] = "Producto creado correctamente.";
        header('Location: ../admin/adminProductos.php');
        exit();
        
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error al crear el producto: " . $e->getMessage();
        header('Location: ../admin/adminProductos.php');
        exit();
    }
}

//EDITAR PRODUCTO

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'edit') {
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];
    $precio_anterior = $_POST['precio_anterior'] ?? null;
    $stock = $_POST['stock'] ?? null;
    $descripcion = $_POST['descripcion'] ?? '';
    $activo = isset($_POST['activo']) ? 1 : 0;
    $imagen = null;

    //Subir imagen
    if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = $_FILES['imagen']['name'];
        $tipoArchivo = $_FILES['imagen']['type'];
        $tamanioArchivo = $_FILES['imagen']['size'];
        $rutaTemporal = $_FILES['imagen']['tmp_name'];
        $carpetaDestino = __DIR__ . '/../public/assets/img/';

        // Validaciones de la imagen

        // Verificar que el archivo es una imagen válida
        $infoImagen = getimagesize($rutaTemporal);
        if($infoImagen === false) {
            $_SESSION['error'] = "El archivo subido no es una imagen válida.";
            header('Location: ../admin/adminProductos.php');
            exit();
        }
        // Verificar tamaño máximo (10MB)
        if ($tamanioArchivo > 10 * 1024 * 1024) { // 10MB
            $_SESSION['error'] = "El tamaño de la imagen no debe exceder los 10MB.";
            header('Location: ../admin/adminProductos.php');
            exit();
        }
        // Verificar dimensiones máximas (1024x1024 píxeles)
        $ancho = $infoImagen[0];
        $alto = $infoImagen[1];
        $mime = $infoImagen['mime'];

        if ($ancho > 1024 || $alto > 1024) {
            $_SESSION['error'] = "Las dimensiones de la imagen no deben exceder los 1024x1024 píxeles.";
            header('Location: ../admin/adminProductos.php');
            exit();
        }
        // Verificar tipo de archivo permitido
        $mimesPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($mime, $mimesPermitidos)) {
            $_SESSION['error'] = "Solo se permiten imágenes en formato JPEG, PNG o GIF.";
            header('Location: ../admin/adminProductos.php');
            exit();
        }
        // Mover el archivo a la carpeta destino
        move_uploaded_file($rutaTemporal, $carpetaDestino . $nombreArchivo);
        $imagen = $nombreArchivo;

        
    }

    try {
        if ($imagen) {
            $sql_update = "UPDATE articulos SET codigo = :codigo, nombre = :nombre, descripcion = :descripcion, 
                           categoria = :categoria, stock = :stock, precio = :precio, imagen = :imagen, 
                           precio_anterior = :precio_anterior, activo = :activo WHERE codigo = :codigo";
        } else {
            $sql_update = "UPDATE articulos SET codigo = :codigo, nombre = :nombre, descripcion = :descripcion, 
                           categoria = :categoria, stock = :stock, precio = :precio, 
                           precio_anterior = :precio_anterior, activo = :activo WHERE codigo = :codigo";
        }

        $stmt_update = $con->prepare($sql_update);
        $stmt_update->bindParam(':codigo', $codigo);
        $stmt_update->bindParam(':nombre', $nombre);
        $stmt_update->bindParam(':descripcion', $descripcion);
        $stmt_update->bindParam(':categoria', $categoria);
        $stmt_update->bindParam(':stock', $stock);
        $stmt_update->bindParam(':precio', $precio);
        if ($imagen) {
            $stmt_update->bindParam(':imagen', $imagen);
        }
        $stmt_update->bindParam(':precio_anterior', $precio_anterior);
        $stmt_update->bindParam(':activo', $activo);
        $stmt_update->bindParam(':codigo', $codigo);
        $stmt_update->execute();

        $_SESSION['success'] = "Producto actualizado correctamente.";
        header('Location: ../admin/adminProductos.php');
        exit();

    } catch (PDOException $e) {
        $_SESSION['error'] = "Error al actualizar el producto: " . $e->getMessage();
        header('Location: ../admin/adminProductos.php');
        exit();
    }
}

//Eliminar producto
if(isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $codigo = $_GET['id'];

    try {
        $sql_delete = "DELETE FROM articulos WHERE codigo = :codigo";
        $stmt_delete = $con->prepare($sql_delete);
        $stmt_delete->bindParam(':codigo', $codigo);
        $stmt_delete->execute();

        $_SESSION['success'] = "Producto eliminado correctamente.";
        header('Location: ../admin/adminProductos.php');
        exit();

    } catch (PDOException $e) {
        $_SESSION['error'] = "Error al eliminar el producto: " . $e->getMessage();
        header('Location: ../admin/adminProductos.php');
        exit();
    }
}





