<?php
// Determinar la ruta base según desde dónde se incluye
$current_path = $_SERVER['PHP_SELF'];
$is_root = (basename($current_path) === 'index.php' && strpos($current_path, '/views/') === false);
$in_categorias = (strpos($current_path, '/views/tienda/categorias/') !== false);
$in_tienda = (strpos($current_path, '/views/tienda/') !== false && !$in_categorias);

if ($is_root) {
    $cart_url = 'views/tienda/cart.php';
} elseif ($in_categorias) {
    $cart_url = '../cart.php';
} elseif ($in_tienda) {
    $cart_url = 'cart.php';
} else {
    $cart_url = '../tienda/cart.php';
}

require_once __DIR__ . '/../../helpers/cart_helper.php';
$cart_count = getCartCount();
?>

<a href="<?= $cart_url ?>" class="btn btn-outline-primary btn-icon position-relative" aria-label="Carrito">
  <i class="bi bi-bag"></i>
  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartBadge">
    <?= $cart_count ?>
  </span>
</a>