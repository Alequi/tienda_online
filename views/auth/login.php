<?php
session_start();
$success = $_SESSION['success'] ?? '';
unset($_SESSION['success']);
require_once __DIR__ . '/../../config/conexion.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Tienda online</title>
    <link rel="icon" type="image/png" href="../../public/assets/img/logo-tienda.png"/>
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
<!-- NAVBAR + CATEGORIES + CAROUSEL -->

<main class="flex-grow-1">
  <div class="container-xxl my-3">
    <div class="row g-3 align-items-start">

      <!-- CATEGORÍAS (izquierda, desktop) -->
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

      <!-- ZONA DERECHA (navbar + login) -->
      <div class="col-lg-9">

        <!-- NAVBAR (derecha) -->
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

            <ul class="navbar-nav ms-auto">
              <li class="nav-item"><a class="nav-link active" href="login.php">Login</a></li>
              <li class="nav-item"><a class="nav-link" href="registro.php">Registro</a></li>
            </ul>
          </div>
        </nav>

        <!-- LOGIN CENTRADO en el espacio derecho -->
        <div class="d-flex justify-content-center align-items-center py-4 py-lg-5">
          <div class="w-100" style="max-width: 460px;">
            <div class="card border-0 shadow-sm">
              <div class="card-body p-4 p-md-5">

                <h2 class="mb-2 text-center fw-bold">Accede a tu cuenta</h2>
                <p class="text-center text-body-secondary mb-4">Gestiona tus pedidos y datos de envío</p>
                
                <?php if(!empty($success)): ?>
                <div class="alert alert-success mb-4" role="alert">
                  <i class="bi bi-check-circle-fill me-2"></i>
                  <?php echo htmlspecialchars($success); ?>
                </div>
                <?php endif; ?>

                <form method="post" action="../../actions/login_action.php">
                  <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="tucorreo@email.com" required>
                  </div>

                  <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
                  </div>

                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="remember">
                      <label class="form-check-label" for="remember">Recuérdame</label>
                    </div>
                    <a href="#" class="small text-primary">¿Olvidaste tu contraseña?</a>
                  </div>

                  <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg d-inline-flex justify-content-center align-items-center gap-2">
                      Iniciar sesión <i class="bi bi-box-arrow-in-right"></i>
                    </button>
                  </div>
                </form>

                <p class="text-center mt-4 mb-0">
                  ¿No tienes cuenta?
                  <a href="registro.php" class="text-primary fw-semibold">Regístrate</a>
                </p>

            

              </div>
            </div>
          </div>
        </div>

      </div><!-- /col-lg-9 -->

    </div><!-- /row -->
  </div><!-- /container -->
</main>


     <!-- FOOTER -->

  <?php include_once __DIR__ . '/../../public/partials/footer.php' ?>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
