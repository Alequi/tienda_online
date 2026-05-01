<?php

require_once __DIR__ . "/../../actions/categorias_action.php";

$basePath = '';
if (isset($_SERVER['SCRIPT_NAME']) && strpos($_SERVER['SCRIPT_NAME'], '/tienda_online/') !== false) {
  $basePath = '/tienda_online';
}

$categoriasActivas = array_filter($categorias, function ($categoria) {
  return (int) $categoria->activo === 1;
});

$categoriasActivasMap = [];
foreach ($categoriasActivas as $categoria) {
  $categoriasActivasMap[$categoria->codigo] = true;
}

$categoriasPorPadre = [];
foreach ($categoriasActivas as $categoria) {
  $padre = $categoria->categoriaPadre ?? null;
  if (empty($padre) || !isset($categoriasActivasMap[$padre])) {
    $padre = 0;
  }
  if (!isset($categoriasPorPadre[$padre])) {
    $categoriasPorPadre[$padre] = [];
  }
  $categoriasPorPadre[$padre][] = $categoria;
}

foreach ($categoriasPorPadre as $padre => $listaCategorias) {
  usort($listaCategorias, function ($a, $b) {
    return strcmp($a->nombre, $b->nombre);
  });
  $categoriasPorPadre[$padre] = $listaCategorias;
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
            <?php if (!empty($categoriasPorPadre[0])): ?>
              <?php foreach ($categoriasPorPadre[0] as $categoria): ?>
                <a href="<?php echo $basePath; ?>/views/tienda/categorias/categoria.php?categoria=<?php echo strtolower($categoria->nombre); ?>" class="list-group-item list-group-item-action fw-semibold">
                  <?php echo htmlspecialchars($categoria->nombre); ?>
                </a>
                <?php if (!empty($categoriasPorPadre[$categoria->codigo])): ?>
                  <?php foreach ($categoriasPorPadre[$categoria->codigo] as $subcategoria): ?>
                    <a href="<?php echo $basePath; ?>/views/tienda/categorias/categoria.php?categoria=<?php echo strtolower($subcategoria->nombre); ?>" class="list-group-item list-group-item-action ps-4 small">
                      <?php echo htmlspecialchars($subcategoria->nombre); ?>
                    </a>
                  <?php endforeach; ?>
                <?php endif; ?>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
