<?php
session_start();
require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../../helpers/auth.php';

if (isLoggedIn()) {
    header("Location: ../../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | Tienda online</title>
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
   <?php include_once __DIR__ . '/../../public/partials/cartbar.php'; ?>

      </div>
    </div>
  </div>
</div>
<!-- NAVBAR + REGISTRO -->

<main class="flex-grow-1">
  <div class="container-xxl my-3">
    <div class="row g-3 align-items-start">

      <!-- ZONA COMPLETA (navbar + registro) -->
      <div class="col-12">

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
              <li class="nav-item"><a class="nav-link " href="login.php">Login</a></li>
              <li class="nav-item"><a class="nav-link active" href="registro.php">Registro</a></li>
            </ul>
          </div>
        </nav>

        <!-- REGISTRO CENTRADO -->
        <div class="d-flex justify-content-center align-items-center py-3 py-lg-4">
          <div class="w-100" style="max-width: 900px;">
            <div class="card border-0 shadow-sm">
              <div class="card-body p-4 p-md-5">

                <h2 class="mb-2 text-center fw-bold">Crea una cuenta</h2>
                <p class="text-center text-body-secondary mb-4">Únete y disfruta de todas nuestras ventajas</p>

                <form method="post" action="../../actions/registro_action.php">
                  <div class="row g-3">
                    
                    <!-- Columna izquierda -->
                    <div class="col-md-6">
                      <label for="nombre" class="form-label">Nombre</label>
                      <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Tu nombre" required>
                    </div>
                    
                    <div class="col-md-6">
                      <label for="apellidos" class="form-label">Apellidos</label>
                      <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Tus apellidos" required>
                    </div>

                    <div class="col-md-6">
                      <label for="dni" class="form-label">DNI</label>
                      <input type="text" class="form-control" id="dni" name="dni" placeholder="12345678A" required>
                    </div>

                    <div class="col-md-6">
                      <label for="telefono" class="form-label">Teléfono</label>
                      <input type="text" class="form-control" id="telefono" name="telefono" placeholder="600123456" required>
                    </div>

                    <div class="col-12">
                      <label for="email" class="form-label">Correo electrónico</label>
                      <input type="email" class="form-control" id="email" name="email" placeholder="tucorreo@email.com" required>
                    </div>

                    <div class="col-md-6">
                      <label for="password" class="form-label">Contraseña</label>
                      <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
                    </div>

                    <div class="col-md-6">
                      <label for="password_confirm" class="form-label">Confirmar contraseña</label>
                      <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="••••••••" required>
                    </div>

                    <div class="col-12">
                      <hr class="my-2">
                      <h6 class="text-muted mb-3"><i class="bi bi-geo-alt"></i> Dirección de envío</h6>
                    </div>

                    <div class="col-12">
                      <label for="direccion" class="form-label">Dirección</label>
                      <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Calle, número, piso..." required>
                    </div>

                    <div class="col-md-6">
                      <label for="localidad" class="form-label">Localidad</label>
                      <input type="text" class="form-control" id="localidad" name="localidad" placeholder="Tu ciudad" required>
                    </div>

                    <div class="col-md-6">
                      <label for="provincia" class="form-label">Provincia</label>
                      <input type="text" class="form-control" id="provincia" name="provincia" placeholder="Tu provincia" required>
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="terminos" required>
                        <label class="form-check-label" for="terminos">
                          Acepto los <a href="#" class="text-primary">términos y condiciones</a>
                        </label>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                          <i class="bi bi-person-plus"></i> Crear mi cuenta
                        </button>
                      </div>
                    </div>

                  </div>
                </form>

                <hr class="my-4">

                <p class="text-center mb-0">
                  ¿Ya tienes cuenta?
                  <a href="login.php" class="text-primary fw-semibold">Inicia sesión</a>
                </p>

              </div>
            </div>
          </div>
        </div>

      </div><!-- /col-12 -->

    </div><!-- /row -->
  </div><!-- /container -->
</main>


     <!-- FOOTER -->

  <?php include_once __DIR__ . '/../../public/partials/footer.php' ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
