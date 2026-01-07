<?php
session_start();
require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../helpers/cart_helper.php';
require_once __DIR__ . '/../../config/conexion.php';

$con = conectar();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto | Tienda online</title>
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
<?php include_once __DIR__ . '/../../public/partials/topbar.php'; ?>

<!-- BRAND + SEARCH + ICONS -->

  <?php include_once __DIR__ . '/../../public/partials/searchbar.php'; ?>

  <!-- SEARCH BAR -->
   <div class="col-lg-3 text-lg-end">
  <?php include_once __DIR__ . '/../../public/partials/cartbar.php'; ?>
  </div>
  </div>
  </div>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-xxl">
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
        <li class="nav-item"><a class="nav-link active" href="contacto.php">Contacto</a></li>
      </ul>

      <ul class="navbar-nav ms-auto">
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

<!-- MAIN CONTENT -->
<main class="flex-grow-1">
  <div class="container-xxl my-5">
    <div class="row">
      <!-- Encabezado -->
      <div class="col-12 mb-4">
        <div class="text-center">
          <h1 class="fw-bold mb-3">Contacta con nosotros</h1>
          <p class="text-muted">¿Tienes alguna pregunta? Estamos aquí para ayudarte</p>
        </div>
      </div>

      <!-- Formulario de contacto -->
      <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0"><i class="bi bi-envelope"></i> Envíanos un mensaje</h5>
          </div>
          <div class="card-body p-4">
            <form id="contactForm">
              <div class="row g-3">
                <div class="col-md-6">
                  <label for="nombre" class="form-label fw-semibold">Nombre completo <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="col-md-6">
                  <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                  <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="col-md-6">
                  <label for="telefono" class="form-label fw-semibold">Teléfono</label>
                  <input type="tel" class="form-control" id="telefono" name="telefono">
                </div>
                <div class="col-md-6">
                  <label for="asunto" class="form-label fw-semibold">Asunto <span class="text-danger">*</span></label>
                  <select class="form-select" id="asunto" name="asunto" required>
                    <option value="">Selecciona un asunto</option>
                    <option value="consulta_producto">Consulta sobre producto</option>
                    <option value="pedido">Información de pedido</option>
                    <option value="devolucion">Devoluciones y cambios</option>
                    <option value="sugerencia">Sugerencia</option>
                    <option value="otro">Otro</option>
                  </select>
                </div>
                <div class="col-12">
                  <label for="mensaje" class="form-label fw-semibold">Mensaje <span class="text-danger">*</span></label>
                  <textarea class="form-control" id="mensaje" name="mensaje" rows="6" required></textarea>
                </div>
                <div class="col-12">
                  <div class="alert alert-info d-none" id="formAlert">
                    
                  </div>
                  <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-send"></i> Enviar mensaje
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Información de contacto -->
      <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm mb-3">
          <div class="card-body p-4">
            <h5 class="card-title fw-bold mb-3"><i class="bi bi-info-circle text-primary"></i> Información de contacto</h5>
            
            <div class="mb-3">
              <h6 class="fw-semibold mb-2"><i class="bi bi-geo-alt text-primary"></i> Dirección</h6>
              <p class="text-muted mb-0">Calle Principal, 123<br>28001 Madrid, España</p>
            </div>

            <div class="mb-3">
              <h6 class="fw-semibold mb-2"><i class="bi bi-telephone text-primary"></i> Teléfono</h6>
              <p class="text-muted mb-0">
                <a href="tel:+34912345678" class="text-decoration-none text-muted">+34 912 345 678</a>
              </p>
            </div>

            <div class="mb-3">
              <h6 class="fw-semibold mb-2"><i class="bi bi-envelope text-primary"></i> Email</h6>
              <p class="text-muted mb-0">
                <a href="mailto:info@mysticwaves.com" class="text-decoration-none text-muted">info@mysticwaves.com</a>
              </p>
            </div>

            <div class="mb-3">
              <h6 class="fw-semibold mb-2"><i class="bi bi-clock text-primary"></i> Horario de atención</h6>
              <p class="text-muted mb-1">Lunes a Viernes: 9:00 - 20:00</p>
              <p class="text-muted mb-0">Sábados: 10:00 - 14:00</p>
            </div>
          </div>
        </div>

        <div class="card border-0 shadow-sm">
          <div class="card-body p-4">
            <h5 class="card-title fw-bold mb-3"><i class="bi bi-share text-primary"></i> Síguenos</h5>
            <div class="d-flex gap-3">
              <a href="#" class="btn btn-outline-primary btn-sm" aria-label="Instagram">
                <i class="bi bi-instagram"></i>
              </a>
              <a href="#" class="btn btn-outline-primary btn-sm" aria-label="Facebook">
                <i class="bi bi-facebook"></i>
              </a>
              <a href="#" class="btn btn-outline-primary btn-sm" aria-label="TikTok">
                <i class="bi bi-tiktok"></i>
              </a>
              <a href="#" class="btn btn-outline-primary btn-sm" aria-label="Pinterest">
                <i class="bi bi-pinterest"></i>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Preguntas frecuentes -->
      <div class="col-12">
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-light py-3">
            <h5 class="mb-0"><i class="bi bi-question-circle"></i> Preguntas frecuentes</h5>
          </div>
          <div class="card-body p-4">
            <div class="accordion" id="faqAccordion">
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    ¿Cuál es el tiempo de entrega?
                  </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                    El tiempo de entrega estándar es de 3-5 días laborables para España peninsular. Para envíos a Baleares, Canarias, Ceuta y Melilla el plazo es de 5-7 días laborables.
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    ¿Puedo devolver un producto?
                  </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                    Sí, aceptamos devoluciones durante los 14 días siguientes a la recepción del pedido. El producto debe estar en perfectas condiciones y con su embalaje original.
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    ¿Los productos tienen garantía?
                  </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                    Todas nuestras joyas cuentan con una garantía de 2 años contra defectos de fabricación. La garantía no cubre el desgaste natural por uso normal.
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</main>

<!-- FOOTER -->
<?php include_once __DIR__ . '/../../public/partials/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../public/assets/lib/scripts/form.js"></script>
</body>
</html>
