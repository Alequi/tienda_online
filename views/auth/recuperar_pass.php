<?php
session_start();
$error = $_SESSION['error_recuperar_pass'] ?? '';
unset($_SESSION['error_recuperar_pass']);
require_once __DIR__ . '/../../config/conexion.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña | Tienda online</title>
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

      <!-- ZONA DERECHA (navbar + recuperar contraseña) -->
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
              <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
              <li class="nav-item"><a class="nav-link" href="registro.php">Registro</a></li>
            </ul>
          </div>
        </nav>

        <!-- FORMULARIO RECUPERAR CONTRASEÑA CENTRADO en el espacio derecho -->
        <div class="d-flex justify-content-center align-items-center py-2 py-lg-2">
          <div class="w-100" style="max-width: 460px;">
            <div class="card border-0 shadow-sm">
              <div class="card-body p-2 p-md-5">

                <div class="text-center mb-1">
                  <i class="bi bi-key-fill text-primary" style="font-size: 3rem;"></i>
                </div>

                <h2 class="mb-2 text-center fw-bold">Recuperar Contraseña</h2>
                <p class="text-center text-body-secondary mb-4">
                  Indica tu DNI y correo electrónico.<br>
            
                </p>
                
                <?php if(!empty($error)): ?>
                <div class="alert alert-danger mb-4" role="alert">
                  <i class="bi bi-exclamation-triangle-fill me-2"></i>
                  <?php echo htmlspecialchars($error); ?>
                </div>
                <?php endif; ?>
                
                <div class="alert alert-info d-flex align-items-start mb-4" role="alert">
                  <i class="bi bi-info-circle-fill me-2 flex-shrink-0 mt-1"></i>
                  <div class="small">
                    Recibiras  una contraseña temporal que podrás cambiar después de iniciar sesión.
                  </div>
                </div>

                <form method="POST" action="../../actions/recuperar_pass_action.php">
                  <div class="mb-3">
                    <label for="dni" class="form-label">DNI</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                      <input 
                        type="text" 
                        class="form-control" 
                        id="dni" 
                        name="dni" 
                        placeholder="Ingresa tu DNI" 
                        required
                        pattern="[0-9]{8}[A-Za-z]?"
                        title="Ingresa un DNI válido (8 dígitos)"
                      >
                    </div>
                  </div>

                  <div class="mb-4">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                      <input 
                        type="email" 
                        class="form-control" 
                        id="email" 
                        name="email" 
                        placeholder="ejemplo@correo.com" 
                        required
                      >
                    </div>
                  </div>

                  <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg d-inline-flex justify-content-center align-items-center gap-2">
                      <i class="bi bi-send-fill"></i> Recuperar Contraseña
                    </button>
                  </div>
                </form>

                <hr class="my-4">

                <p class="text-center mb-0">
                  <a href="login.php" class="text-primary fw-semibold text-decoration-none">
                    <i class="bi bi-arrow-left"></i> Volver al inicio de sesión
                  </a>
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
