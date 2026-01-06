<?php
// Determinar la ruta base según desde dónde se incluye
$is_root = (basename($_SERVER['PHP_SELF']) === 'index.php' && dirname($_SERVER['PHP_SELF']) === '/');
$cart_url = $is_root ? 'views/tienda/cart.php' : '../../views/tienda/cart.php';

require_once __DIR__ . '/../../helpers/cart_helper.php';
$cart_count = getCartCount();
?>

<a href="<?= $cart_url ?>" class="btn btn-outline-primary btn-icon position-relative" aria-label="Carrito">
  <i class="bi bi-bag"></i>
  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartBadge">
    <?= $cart_count ?>
  </span>
</a>