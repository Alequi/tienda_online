<?php
// Determinar rutas según la ubicación del archivo
$current_path = $_SERVER['PHP_SELF'];
$is_root = (basename($current_path) === 'index.php' && strpos($current_path, '/views/') === false);
$in_categorias = (strpos($current_path, '/views/tienda/categorias/') !== false);

if ($is_root) {
    $logo_url = 'public/assets/img/logo-tienda.png';
    $index_url = 'index.php';
} elseif ($in_categorias) {
    $logo_url = '../../../public/assets/img/logo-tienda.png';
    $index_url = '../../../index.php';
} else {
    $logo_url = '../../public/assets/img/logo-tienda.png';
    $index_url = '../../index.php';
}
?>
<div class="bg-white">
  <div class="container-xxl py-3">
    <div class="row align-items-center g-3">
      <div class="col-lg-3">
        <a href="<?= $index_url ?>" class="text-decoration-none d-inline-flex align-items-center gap-2">
          <img src="<?= $logo_url ?>" alt="Mystic Waves" class="img-fluid" style="max-width:200px; height:auto;">

          
        </a>
      </div>


      <div class="col-lg-6">
        <form action="#">
          <div class="input-group">
            <input type="search" class="form-control" placeholder="Buscar anillos, colgantes, plata 925..." aria-label="Buscar">
            <button class="btn btn-outline-secondary" type="submit" aria-label="Buscar">
              <i class="bi bi-search"></i>
            </button>
          </div>
        </form>
      </div>