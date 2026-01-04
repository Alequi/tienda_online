<?php

// Obtener el carrito de la sesión

$cart = $_SESSION['cart'] ?? [];

$cart_items = [];
$total_price = 0.0;

if(!empty($cart)){

    // Obtener los codigos de los productos en el carrito

    $codigos = array_keys($cart);

    // Crear una cadena de placeholders para la consulta SQL

    $placeholders = implode(',' , array_fill(0, count($codigos), '?'));

    try{

        // Preparar y ejecutar la consulta SQL para obtener los detalles de los productos

        $sql = "SELECT codigo, nombre, precio, imagen, stock FROM articulos WHERE codigo IN ($placeholders) AND activo = 1";
        $stmt = $con->prepare($sql);
        $stmt->execute($codigos);
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Construir el array de items del carrito con los detalles y calcular el precio total
        $productos_indexados = [];

        foreach($productos as $producto) {
            $productos_indexados[$producto['codigo']] = $producto;
        }

        foreach($cart as $codigo => $cantidad) {
            if(isset($productos_indexados[$codigo])) {
                $producto = $productos_indexados[$codigo];
                $subtotal = $producto['precio'] * $cantidad;
                
                $cart_items[] = [
                    'codigo' => $codigo,
                    'nombre' => $producto['nombre'],
                    'precio' => $producto['precio'],
                    'imagen' => $producto['imagen'],
                    'cantidad' => $cantidad,
                    'subtotal' => $subtotal,
                    'stock' => $producto['stock']
                ];
                
                $total_price += $subtotal;
            }
        }

    } catch (PDOException $e) {
        $_SESSION['error_cart'] = "Error al obtener los detalles del carrito: " . $e->getMessage();
        header("Location: ../../views/error.php");
        exit();
    }


}

