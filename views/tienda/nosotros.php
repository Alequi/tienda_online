<?php
session_start();
require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../actions/categorias_action.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sobre Nosotros | Mystic Waves</title>
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
  <?php include_once __DIR__ . '/../../public/partials/topbar.php'; ?>

  <!-- BRAND + SEARCH + ICONS -->
  <?php include_once __DIR__ . '/../../public/partials/searchbar.php'; ?>

  <!-- NAVBAR + CONTENT -->
  <div class="container-xxl my-3">
    <div class="row g-3">

      <!-- CATEGORIES (desktop) -->
      <?php include_once __DIR__ . '/../../public/partials/categories_navbar.php'; ?>

      <!-- MAIN CONTENT -->
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
              <li class="nav-item"><a class="nav-link active" href="nosotros.php">Sobre nosotros</a></li>
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

        <!-- Sobre Nosotros Contenido -->
        <div class="mt-3 bg-white rounded-3 p-4">
          
          <!-- Header -->
          <div class="text-center mb-5">
            <h1 class="fw-bold mb-3">Sobre Nosotros</h1>
            <p class="text-muted fs-5">Descubre la historia detrás de Mystic Waves</p>
          </div>

          <!-- Historia -->
          <div class="row mb-5">
            <div class="col-12">
              <h2 class="fw-bold mb-3"><i class="bi bi-stars text-primary"></i> Nuestra Historia</h2>
              <p class="fs-5 text-muted">
                Mystic Waves nace de la pasión por crear joyas únicas que cuenten historias. Desde nuestros inicios, 
                nos hemos dedicado a diseñar piezas que combinan elegancia, calidad y un toque de misterio, 
                inspiradas en la energía de la naturaleza.
              </p>
              <p class="fs-5 text-muted">
                Cada pieza es cuidadosamente elaborada en plata 925 de la más alta calidad, garantizando 
                durabilidad y un brillo excepcional que perdura en el tiempo.
              </p>
            </div>
          </div>

          <!-- Nuestros Valores -->
          <div class="row mb-5">
            <div class="col-12 mb-4">
              <h2 class="fw-bold mb-4"><i class="bi bi-gem text-primary"></i> Nuestros Valores</h2>
            </div>
            <div class="col-md-4 mb-3">
              <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                  <i class="bi bi-award-fill text-primary fs-1 mb-3"></i>
                  <h5 class="card-title fw-bold">Calidad Premium</h5>
                  <p class="card-text text-muted">
                    Solo trabajamos con plata 925 certificada y materiales de la más alta calidad.
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                  <i class="bi bi-palette-fill text-primary fs-1 mb-3"></i>
                  <h5 class="card-title fw-bold">Diseño Único</h5>
                  <p class="card-text text-muted">
                    Cada pieza es diseñada con atención al detalle y un estilo inconfundible.
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                  <i class="bi bi-heart-fill text-primary fs-1 mb-3"></i>
                  <h5 class="card-title fw-bold">Pasión y Compromiso</h5>
                  <p class="card-text text-muted">
                    Nos comprometemos a ofrecer una experiencia de compra excepcional.
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- ¿Por Qué Elegirnos? -->
          <div class="row mb-5">
            <div class="col-12">
              <h2 class="fw-bold mb-4"><i class="bi bi-check-circle-fill text-primary"></i> ¿Por Qué Elegirnos?</h2>
              <ul class="list-unstyled fs-5">
                <li class="mb-3"><i class="bi bi-check-lg text-success me-2"></i> <strong>Envío gratuito</strong> en pedidos superiores a 50€</li>
                <li class="mb-3"><i class="bi bi-check-lg text-success me-2"></i> <strong>Garantía de calidad</strong> en todas nuestras piezas</li>
                <li class="mb-3"><i class="bi bi-check-lg text-success me-2"></i> <strong>Atención personalizada</strong> para ayudarte en tu elección</li>
                <li class="mb-3"><i class="bi bi-check-lg text-success me-2"></i> <strong>Devoluciones fáciles</strong> en 30 días</li>
                <li class="mb-3"><i class="bi bi-check-lg text-success me-2"></i> <strong>Ediciones limitadas</strong> y diseños exclusivos</li>
              </ul>
            </div>
          </div>

          <!-- CTA -->
          <div class="text-center bg-light rounded-3 p-5">
            <h3 class="fw-bold mb-3">¿Listo para encontrar tu joya perfecta?</h3>
            <p class="text-muted mb-4">Explora nuestra colección y descubre piezas que cuentan tu historia</p>
            <a href="../../index.php" class="btn btn-primary btn-lg px-5">Ver Colección</a>
          </div>

        </div>

      </div>
    </div>
  </div>

  <!-- FOOTER -->
  <?php include_once __DIR__ . '/../../public/partials/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
