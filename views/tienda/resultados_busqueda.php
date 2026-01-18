<?php
session_start();
require_once __DIR__ . "/../../helpers/auth.php";
require_once __DIR__ . "/../../actions/categorias_action.php";

// Obtener término de búsqueda y resultados de la sesión
$last_search = $_SESSION['last_search'] ?? '';
$resultados = $_SESSION['search_results'] ?? [];

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mystic Waves | Tienda online</title>
  <link rel="icon" type="image/png" href="../../public/assets/img/logo-tienda.png" />
  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">


  <!-- Customized Bootstrap Stylesheet -->
  <link href="../../public/assets/css/style.css" rel="stylesheet">

</head>

<body class="d-flex flex-column min-vh-100">

  <!-- TOPBAR -->

  <?php include_once '../../public/partials/topbar.php'; ?>

  <!-- BRAND + SEARCH + ICONS -->

  <?php include_once '../../public/partials/searchbar.php'; ?>

  <!-- NAVBAR + CATEGORIES + CAROUSEL -->
  <div class="container-xxl my-3">
    <div class="row g-3">

      <!-- CATEGORIES (desktop) -->
      
      <?php include_once '../../public/partials/categories_navbar.php'; ?>

      <!-- MAIN (navbar + carousel) -->
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
              <li class="nav-item"><a class="nav-link active" href="#">Inicio</a></li>
              <li class="nav-item"><a class="nav-link" href="#">Tienda</a></li>
              <li class="nav-item"><a class="nav-link" href="#">Colecciones</a></li>
              <li class="nav-item"><a class="nav-link" href="nosotros.php">Sobre nosotros</a></li>
              <li class="nav-item"><a class="nav-link" href="contacto.php">Contacto</a></li>
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

        <!-- Carousel -->
        <div id="shopCarousel" class="carousel slide mt-3" data-bs-ride="carousel">
          <div class="carousel-inner rounded-3 overflow-hidden">
            <div class="carousel-item active">
              <img src="../../public/assets/img/hero-1.png" class="d-block w-100" alt="Colección" style="height:410px; object-fit:cover;">
              <div class="carousel-caption d-flex h-100 align-items-center justify-content-center">
                <div class="p-3" style="max-width: 720px;">
                  <h6 class="text-uppercase fw-semibold mb-2 text-white">Nueva colección</h6>
                  <h2 class="fw-bold mb-3">Joyas con alma, para cada día</h2>
                  <a href="#" class="btn btn-primary">Comprar ahora</a>

                </div>
              </div>
            </div>

            <div class="carousel-item">
              <img src="../../public/assets/img/hero-2.png" class="d-block w-100" alt="Anillos" style="height:410px; object-fit:cover;">
              <div class="carousel-caption d-flex h-100 align-items-center justify-content-center">
                <div class="p-3" style="max-width: 720px;">
                  <h6 class="text-uppercase fw-semibold mb-2 text-white">Edicion Limitada</h6>
                  <h2 class="fw-bold mb-3">Anillos elegantes en Plata 925</h2>
                  <a href="#" class="btn btn-primary">Comprar ahora</a>
                </div>
              </div>
            </div>
          </div>

          <button class="carousel-control-prev" type="button" data-bs-target="#shopCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
          </button>

          <button class="carousel-control-next" type="button" data-bs-target="#shopCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
          </button>
        </div>

      </div>
    </div>
  </div>

  <!-- PRODUCTS GRID -->

  <h1 class="text-center mb-2 mt-2"><i class="bi bi-search text-primary"></i> Has buscado "<?= htmlspecialchars($last_search) ?>" </h1>

 <div class="container-xxl mt-3 mb-5">
    <div class="row g-4">
      <?php if (!empty($resultados)): ?>
        <?php foreach ($resultados as $producto): ?>
          <div class="col-6 col-md-4 col-lg-3">
            <div class="card h-100">
              <img src="../../public/assets/img/<?php echo htmlspecialchars($producto['imagen']); ?>" class="card-img-top" alt="Producto <?php echo htmlspecialchars($producto['codigo']); ?>">
              <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?php echo htmlspecialchars($producto['nombre']); ?></h5>
                <p class="card-text text-muted mb-4">
                  <span class="fw-bold text-primary fs-5"><?php echo number_format($producto['precio'], 2); ?>€</span>
                  <?php if (isset($producto['precio_anterior']) && $producto['precio_anterior'] > 0): ?>
                    <s class="ms-2"><?php echo number_format($producto['precio_anterior'], 2); ?>€</s>
                  <?php endif; ?>
                </p>
                <a href="../tienda/producto.php?codigo=<?php echo htmlspecialchars($producto['codigo']); ?>" class="btn btn-primary mt-auto">Ver más</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-12">
          <div class="alert alert-info text-center">
            <i class="bi bi-search"></i> No se encontraron productos para "<?php echo htmlspecialchars($last_search); ?>"
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- PRODUCTS GRID -->


  <!-- FOOTER -->

  <?php include_once '../../public/partials/footer.php'; ?>

  <!-- FOOTER -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>