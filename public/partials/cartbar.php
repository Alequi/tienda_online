 <a href="../../views/tienda/cart.php" class="btn btn-outline-primary btn-icon position-relative" aria-label="Carrito">
  <i class="bi bi-bag"></i>
  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartBadge">
    <?php 
      $cart_count = 0;
      if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $qty) {
          $cart_count += (int)$qty;
        }
      }
      echo $cart_count;
    ?>
  </span>
</a>