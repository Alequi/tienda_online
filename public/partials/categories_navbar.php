<?php

require_once __DIR__ . "/../../actions/categorias_action.php";

$basePath = '';
if (isset($_SERVER['SCRIPT_NAME']) && strpos($_SERVER['SCRIPT_NAME'], '/tienda_online/') !== false) {
  $basePath = '/tienda_online';
}

?>

<div class="col-lg-3">
        <button class="btn btn-primary w-100 d-flex align-items-center justify-content-between px-3"
          style="height:56px;"
          data-bs-toggle="collapse" data-bs-target="#verticalCats"
          aria-expanded="false" aria-controls="verticalCats" type="button">
          <span class="fw-semibold">Categorías</span>
          <i class="bi bi-chevron-down"></i>
        </button>

        <div class="collapse d-lg-block border border-top-0" id="verticalCats">
          <div class="list-group list-group-flush" style="max-height: 410px; overflow:auto;">
            

            <?php foreach ($categorias as $categoria): ?>
                <?php if (!$categoria->activo) continue; ?>
              <a href="<?php echo $basePath; ?>/views/tienda/categorias/categoria.php?categoria=<?php echo strtolower($categoria->nombre); ?>" class="list-group-item list-group-item-action "><?php echo htmlspecialchars($categoria->nombre); ?></a>
            <?php endforeach; ?>

        

            
          </div>
        </div>
      </div>
