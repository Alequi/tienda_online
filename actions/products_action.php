<?php

require_once __DIR__ . '/../config/conexion.php';

$con = conectar();

$sql = "SELECT * FROM articulos where activo = 1 LIMIT 8";
$stmt = $con->prepare($sql);
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_OBJ);
?>

 <div class="container-xxl mt-5 mb-5">
    <div class="row g-4">
      <?php foreach ($productos as $producto): ?>
        <div class="col-6 col-md-4 col-lg-3">
          <div class="card h-100">
            <img src="public/assets/img/<?php echo $producto->imagen; ?>" class="card-img-top" alt="Producto <?php echo $producto->codigo; ?>">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title"> <?php echo $producto->nombre; ?></h5>
              <p class="card-text text-muted mb-4">€<?php echo number_format($producto->precio, 2); ?></p>
              <a href="views/producto.php?id=<?php echo $producto->codigo; ?>" class="btn btn-primary mt-auto">Ver más</a>

            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>