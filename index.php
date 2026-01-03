<?php
session_start();
require_once "helpers/auth.php";

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mystic Waves | Tienda online</title>
    <link rel="icon" type="image/png" href="public/assets/img/logo-tienda.png" />
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

   
    <!-- Customized Bootstrap Stylesheet -->
     <link href="public/assets/css/style.css" rel="stylesheet">
    
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
          <img src="public/assets/img/logo-tienda.png" alt="Mystic Waves" class="img-fluid" style="max-width:200px; height:auto;">

          
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

<!-- NAVBAR + CATEGORIES + CAROUSEL -->
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
                <li><a class="dropdown-item" href="views/user/panel.php"><i class="bi bi-person"></i> Panel de usuario</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="actions/logout_action.php"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a></li>
              </ul>
            </li>
          </ul>
          <?php else: ?>
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="views/auth/login.php">Login</a></li>
            <li class="nav-item"><a class="nav-link" href="views/auth/registro.php">Registro</a></li>
          </ul>
          <?php endif; ?>
        </div>
      </nav>

      <!-- Carousel -->
      <div id="shopCarousel" class="carousel slide mt-3" data-bs-ride="carousel">
        <div class="carousel-inner rounded-3 overflow-hidden">
          <div class="carousel-item active">
            <img src="public/assets/img/hero-1.png" class="d-block w-100" alt="Colección" style="height:410px; object-fit:cover;">
            <div class="carousel-caption d-flex h-100 align-items-center justify-content-center">
              <div class="p-3" style="max-width: 720px;">
                <h6 class="text-uppercase fw-semibold mb-2 text-white">Nueva colección</h6>
                <h2 class="fw-bold mb-3">Joyas con alma, para cada día</h2>
                <a href="#" class="btn btn-primary">Comprar ahora</a>

              </div>
            </div>
          </div>

          <div class="carousel-item">
            <img src="public/assets/img/hero-2.png" class="d-block w-100" alt="Anillos" style="height:410px; object-fit:cover;">
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
  <div class="container-xxl mt-5 mb-5">
    <div class="row g-4">
      <?php for ($i = 1; $i <= 8; $i++): ?>
        <div class="col-6 col-md-4 col-lg-3">
          <div class="card h-100">
            <img src="public/assets/img/producto-<?php echo $i; ?>.jpg" class="card-img-top" alt="Producto <?php echo $i; ?>">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">Producto <?php echo $i; ?></h5>
              <p class="card-text text-muted mb-4">€<?php echo number_format(19.99 + $i, 2); ?></p>
              <a href="#" class="btn btn-primary mt-auto">Añadir al carrito</a
>
            </div>
          </div>
        </div>
      <?php endfor; ?>
    </div>
  </div>

<!-- PRODUCTS GRID -->
  
 
    <!-- FOOTER -->

  <footer class="bg-dark text-light py-4 mt-auto">
        <div class="container d-flex flex-column flex-md-row flex-wrap
              justify-content-center justify-content-md-between
              align-items-center text-center text-md-start">

            <div class="col-md-4 d-flex align-items-center justify-content-center justify-content-md-start mb-3 mb-md-0">
                <a href="/" class="mb-3 me-2 mb-md-0 text-light text-decoration-none lh-1">
                    <img src="public/assets/img/logo-tienda-blanco-sin.png" alt="Logo" width="50" height="auto" />
                </a>
                <span class="mb-3 mb-md-0">&copy; 2025 Mystic Waves</span>
            </div>

          

            <ul class="nav justify-content-center justify-content-md-end list-unstyled d-flex">
                <li class="ms-3">
                    <a class="text-light" href="#" aria-label="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram"
                             viewBox="0 0 16 16">
                            <path
                                d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334" />
                        </svg>
                    </a>
                </li>
                <li class="ms-3">
                    <a class="text-light" href="#" aria-label="Facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook"
                             viewBox="0 0 16 16">
                            <path
                                d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951" />
                        </svg>
                    </a>
                </li>
            </ul>

        </div>

    </footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

