<?php
session_start();
require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../actions/product_detail_action.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($producto['nombre']); ?> | Tienda online</title>
  <link rel="icon" type="image/png" href="../../public/assets/img/logo-tienda.png" />
  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link href="../../public/assets/css/style.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">

<!-- TOPBAR -->
<div class="bg-light border-bottom mb-3">
  <div class="container-xxl py-2">
    <div class="row align-items-center">
      <div class="col-lg-6 d-none d-lg-block">
        <div class="d-inline-flex align-items-center">
          <a class="text-decoration-none text-muted" href="#">FAQs</a>
          <span class="text-muted px-2">|</span>
          <a class="text-decoration-none text-muted" href="#">Ayuda</a>
          <span class="text-muted px-2">|</span>
          <a class="text-decoration-none text-muted" href="#">Soporte</a>
        </div>
      </div>

      <div class="col-lg-6 text-center text-lg-end">
        <div class="d-inline-flex align-items-center">
          <a class="text-muted px-2" href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
          <a class="text-muted px-2" href="#" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
          <a class="text-muted px-2" href="#" aria-label="Pinterest"><i class="bi bi-pinterest"></i></a>
          <a class="text-muted px-2" href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- BRAND + SEARCH + ICONS -->
<div class="bg-white">
  <div class="container-xxl py-3">
    <div class="row align-items-center g-3">
      <div class="col-lg-3">
        <a href="#" class="text-decoration-none d-inline-flex align-items-center gap-2">
          <img src="../../public/assets/img/logo-tienda.png" alt="Mystic Waves" class="img-fluid" style="max-width:200px; height:auto;">

          
        </a>
      </div>

<!-- SEARCH BAR -->
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
<!-- SEARCH BAR -->

      <div class="col-lg-3 text-lg-end">
        <a href="#" class="btn btn-outline-primary btn-icon position-relative" aria-label="Carrito">
  <i class="bi bi-bag"></i>
  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">0</span>
</a>

      </div>
    </div>
  </div>
</div>

<!-- NAVBAR + CATEGORIES + PRODUCT -->
  <div class="container-xxl my-3">
    <div class="row g-3">

      <!-- CATEGORIES (desktop) -->
      <div class="col-lg-3 d-none d-lg-block">
        <button class="btn btn-primary w-100 d-flex align-items-center justify-content-between px-3"
          style="height:56px;"
          data-bs-toggle="collapse" data-bs-target="#verticalCats"
          aria-expanded="true" aria-controls="verticalCats" type="button">
          <span class="fw-semibold">Categorías</span>
          <i class="bi bi-chevron-down"></i>
        </button>

        <div class="collapse show border border-top-0" id="verticalCats">
          <div class="list-group list-group-flush" style="max-height: 410px; overflow:auto;">
            <a href="#" class="list-group-item list-group-item-action">Novedades</a>
            <a href="#" class="list-group-item list-group-item-action">Anillos</a>
            <a href="#" class="list-group-item list-group-item-action">Colgantes</a>
            <a href="#" class="list-group-item list-group-item-action">Pulseras</a>
            <a href="#" class="list-group-item list-group-item-action">Pendientes</a>

            <!-- Dropdown simple dentro de la lista -->
            <div class="list-group-item p-0">
              <button class="btn w-100 text-start d-flex justify-content-between align-items-center px-3 py-2"
                data-bs-toggle="collapse" data-bs-target="#cat-material" type="button">
                Material <i class="bi bi-chevron-down"></i>
              </button>
              <div class="collapse" id="cat-material">
                <a class="list-group-item list-group-item-action ps-4" href="#">Plata 925</a>
                <a class="list-group-item list-group-item-action ps-4" href="#">Acero inoxidable</a>
                <a class="list-group-item list-group-item-action ps-4" href="#">Baño de oro</a>
              </div>
            </div>

            <a href="#" class="list-group-item list-group-item-action">Regalos</a>
          </div>
        </div>
      </div>

      <!-- MAIN (navbar + product) -->
      <div class="col-lg-9">
        <!-- Navbar -->
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
              <li class="nav-item"><a class="nav-link" href="#">Contacto</a></li>
            </ul>

            <?php if (isLoggedIn()): ?>
              <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle"></i> Hola, <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="../../views/user/panel.php"><i class="bi bi-person"></i> Panel de usuario</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="../../actions/logout_action.php"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a></li>
                  </ul>
                </li>
              </ul>
            <?php else: ?>
              <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="../../views/auth/login.php">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="../../views/auth/registro.php">Registro</a></li>
              </ul>
            <?php endif; ?>
          </div>
        </nav>

        <!-- Product Detail -->
        <div class="mt-3">
          <?php include_once __DIR__ . '/../../public/partials/producto_detalle.php'; ?>
        </div>
      </div>
    </div>
  </div>

  <?php include_once __DIR__ . '/../../public/partials/footer.php'; ?>

  <script src="../../public/assets/lib/scripts/quantity_selector.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>