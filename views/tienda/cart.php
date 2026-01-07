<?php
session_start();
require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../config/conexion.php';
$con = conectar();
require_once __DIR__ . '/../../actions/cart/view.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Carrito de Compras | Mystic Waves</title>
  <link rel="icon" type="image/png" href="../../public/assets/img/logo-tienda.png" />
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link href="../../public/assets/css/style.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">

  <?php include_once __DIR__ . '/../../public/partials/topbar.php'; ?>
  
  <!-- BRAND + SEARCH + CART -->
  <div class="bg-white">
    <div class="container-xxl py-3">
      <div class="row align-items-center g-3">
        <div class="col-lg-3">
          <a href="../../index.php" class="text-decoration-none d-inline-flex align-items-center gap-2">
            <img src="../../public/assets/img/logo-tienda.png" alt="Mystic Waves" class="img-fluid" style="max-width:200px; height:auto;">
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

        <div class="col-lg-3 text-lg-end">
          <?php include_once __DIR__ . '/../../public/partials/cartbar.php'; ?>
        </div>
      </div>
    </div>
  </div> 

  <!-- Navbar -->
  <div class="container-xxl my-3">
    <nav class="navbar navbar-expand-lg navbar-light bg-light rounded-3 px-3">
      <a class="navbar-brand d-lg-none fw-bold" href="#">Mystic Waves</a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#shopNavbar"
              aria-controls="shopNavbar" aria-expanded="false" aria-label="Abrir menú">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="shopNavbar">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="../../index.php">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Tienda</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Colecciones</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Sobre nosotros</a></li>
          <li class="nav-item"><a class="nav-link" href="../tienda/contacto.php">Contacto</a></li>
        </ul>

        <?php if (isLoggedIn()): ?>
              <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle"></i> Hola, <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                  </a>
                  <?php if (isAdmin()): ?>


                     <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="../../admin/adminPanel.php"><i class="bi bi-person"></i> Panel de Administrador</a></li>
                    <li>
                      <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="../../actions/logout_action.php"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a></li>
                  </ul>
                </li>
              </ul>
                  <?php else: ?>
                  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="../user/panel.php"><i class="bi bi-person"></i> Panel de usuario</a></li>
                    <li>
                      <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="../../actions/logout_action.php"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a></li>
                  </ul>
                </li>
              </ul>
                  <?php endif; ?>
            <?php else: ?>
              <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="../auth/login.php">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="../auth/registro.php">Registro</a></li>
              </ul>
            <?php endif; ?>
          </div>
        </nav>
  </div>

  <!-- Cart Content -->
  <main class="container-xxl my-4 flex-grow-1">
    <h2 class="mb-4">
      <i class="bi bi-cart3 text-primary"></i> Tu carrito
    </h2>

    <?php if (empty($cart_items)): ?>
      <!-- Empty Cart -->
      <div class="card text-center py-5">
        <div class="card-body">
          <i class="bi bi-cart-x display-1 text-muted mb-3"></i>
          <h4 class="mb-3">Tu carrito está vacío</h4>
          <p class="text-muted mb-4">Explora nuestra tienda y añade productos que te gusten</p>
          <a href="../../index.php" class="btn btn-primary">
            <i class="bi bi-shop me-2"></i>Ir a la tienda
          </a>
        </div>
      </div>
    <?php else: ?>
      <!-- Cart Items -->
      <div class="row g-4">
        <div class="col-lg-8">
          <div class="card shadow-sm">
            <div class="card-body">
              <?php foreach ($cart_items as $item): ?>
                <div class="row align-items-center border-bottom pb-3 mb-3">
                  <!-- Product Image -->
                  <div class="col-md-2">
                    <img src="../../public/assets/img/<?= htmlspecialchars($item['imagen']) ?>" 
                         class="img-fluid rounded" 
                         alt="<?= htmlspecialchars($item['nombre']) ?>">
                  </div>

                  <!-- Product Details -->
                  <div class="col-md-4">
                    <h6 class="mb-1"><?= htmlspecialchars($item['nombre']) ?></h6>
                    <p class="text-muted small mb-0">Código: <?= htmlspecialchars($item['codigo']) ?></p>
                    <p class="text-primary fw-bold mb-0"><?= number_format($item['precio'], 2) ?>€</p>
                  </div>

                  <!-- Quantity -->
                  <div class="col-md-3">
                    <div class="input-group input-group-sm">
                      <button class="btn btn-outline-secondary" type="button" 
                              data-action="decrease"
                              data-codigo="<?= htmlspecialchars($item['codigo']) ?>"
                              data-cantidad="<?= $item['cantidad'] ?>">
                        <i class="bi bi-dash"></i>
                      </button>
                      <input type="number" 
                             class="form-control text-center" 
                             value="<?= $item['cantidad'] ?>" 
                             min="1" 
                             max="<?= $item['stock'] ?>"
                             data-action="manual-update"
                             data-codigo="<?= htmlspecialchars($item['codigo']) ?>"
                             style="max-width: 60px;">
                      <button class="btn btn-outline-secondary" type="button" 
                              data-action="increase"
                              data-codigo="<?= htmlspecialchars($item['codigo']) ?>"
                              data-cantidad="<?= $item['cantidad'] ?>"
                              data-stock="<?= $item['stock'] ?>">
                        <i class="bi bi-plus"></i>
                      </button>
                    </div>
                    <?php if ($item['cantidad'] > $item['stock']): ?>
                      <small class="text-danger d-block mt-1">Stock: <?= $item['stock'] ?></small>
                    <?php endif; ?>
                  </div>

                  <!-- Subtotal & Remove -->
                  <div class="col-md-3 text-end">
                    <p class="fw-bold mb-2"><?= number_format($item['subtotal'], 2) ?>€</p>
                    <button type="button" 
                            data-action="remove"
                            data-codigo="<?= htmlspecialchars($item['codigo']) ?>" 
                            class="btn btn-sm btn-outline-danger">
                      <i class="bi bi-trash"></i> Eliminar
                    </button>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
          <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
              <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>Resumen del Pedido</h5>
            </div>
            <div class="card-body">
              <div class="d-flex justify-content-between mb-2">
                <span>Subtotal:</span>
                <span><?= number_format($total_price, 2) ?>€</span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span>Envío:</span>
                <span><?= $total_price >= 50 ? 'GRATIS' : number_format(4.95, 2) . '€' ?></span>
              </div>
              <hr>
              <div class="d-flex justify-content-between mb-3">
                <strong>Total:</strong>
                <strong class="text-primary fs-5">
                  <?= number_format($total_price + ($total_price >= 50 ? 0 : 4.95), 2) ?>€
                </strong>
              </div>

              <?php if ($total_price < 50): ?>
                <div class="alert alert-info small mb-3">
                  <i class="bi bi-info-circle me-1"></i>
                  Añade <?= number_format(50 - $total_price, 2) ?>€ más para envío gratis
                </div>
              <?php endif; ?>

              <a href="#" class="btn btn-primary w-100 mb-2">
                <i class="bi bi-credit-card me-2"></i>Proceder al Pago
              </a>
              <a href="../../index.php" class="btn btn-outline-secondary w-100">
                <i class="bi bi-arrow-left me-2"></i>Seguir Comprando
              </a>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </main>

  <?php include_once __DIR__ . '/../../public/partials/footer.php'; ?>

  <script src="../../public/assets/lib/scripts/cart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

