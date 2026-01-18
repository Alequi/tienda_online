<?php
// Determinar rutas según la ubicación del archivo
$current_path = $_SERVER['PHP_SELF'];
$is_root = (basename($current_path) === 'index.php' && strpos($current_path, '/views/') === false);
$in_categorias = (strpos($current_path, '/views/tienda/categorias/') !== false);

if ($is_root) {
    $logo_url = 'public/assets/img/logo-tienda.png';
    $index_url = 'index.php';
    $search_url = 'actions/busqueda_action.php';
} elseif ($in_categorias) {
    $logo_url = '../../../public/assets/img/logo-tienda.png';
    $index_url = '../../../index.php';
    $search_url = '../../../actions/busqueda_action.php';
} else {
    $logo_url = '../../public/assets/img/logo-tienda.png';
    $index_url = '../../index.php';
    $search_url = '../../actions/busqueda_action.php';
}
?>
<div class="bg-white">
  <div class="container-xxl py-3">
    <div class="row align-items-center g-3">
      <div class="col-12 col-lg-3 text-center text-lg-start">
        <a href="<?= $index_url ?>" class="text-decoration-none d-inline-flex align-items-center gap-2">
          <img src="<?= $logo_url ?>" alt="Mystic Waves" class="img-fluid" style="max-width:200px; height:auto;">

          
        </a>
      </div>


      <div class="col-9 col-lg-6">
        <form action="<?= $search_url ?>" method="GET" role="search">
          <div class="input-group">
            <input type="search" class="form-control" name="query" placeholder="Buscar anillos, colgantes, plata 925..." aria-label="Buscar">
            <button class="btn btn-outline-secondary" type="submit" aria-label="Buscar">
              <i class="bi bi-search"></i>
            </button>
          </div>
        </form>
      </div>
      
      <div class="col-3 col-lg-3 text-end">
        <?php include_once dirname(__FILE__) . '/cartbar.php'; ?>
      </div>
    </div>
  </div>
</div>