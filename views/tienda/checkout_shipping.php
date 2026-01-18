<?php
session_start();
require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../config/conexion.php';
$con = conectar();
require_once __DIR__ . '/../../actions/cart/view.php';
require_once __DIR__ . '/../../actions/usuarios_action.php';
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
        <div class="col-12 col-lg-3 text-center text-lg-start">
          <a href="../../index.php" class="text-decoration-none d-inline-flex align-items-center gap-2">
            <img src="../../public/assets/img/logo-tienda.png" alt="Mystic Waves" class="img-fluid" style="max-width:200px; height:auto;">
          </a>
        </div>

        <div class="col-9 col-lg-6">
          <form action="#">
            <div class="input-group">
              <input type="search" class="form-control" placeholder="Buscar anillos, colgantes, plata 925..." aria-label="Buscar">
              <button class="btn btn-outline-secondary" type="submit" aria-label="Buscar">
                <i class="bi bi-search"></i>
              </button>
            </div>
          </form>
        </div>

        <div class="col-3 col-lg-3 text-end">
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
                  <?php if (isAdmin() || isEditor()): ?>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                      <li><a class="dropdown-item" href="../../admin/adminPanel.php"><i class="bi bi-wrench-adjustable-circle"></i> Panel de Administrador</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="../user/panel.php"><i class="bi bi-person"></i> Perfil Personal</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="../../actions/logout_action.php"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a></li>
                    </ul>
                  </li>
                </ul>
                  <?php else: ?>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                      <li><a class="dropdown-item" href="../user/panel.php"><i class="bi bi-person"></i> Panel de usuario</a></li>
                      <li><hr class="dropdown-divider"></li>
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

  <div class="container-xxl flex-grow-1 my-4">
    <div class="row g-4">

    <?php if (!isLoggedIn()): ?>
      <div class="col-12">
        <div class="card border-0 shadow-sm">
          <div class="card-body text-center py-5">
            <i class="bi bi-lock-fill text-primary" style="font-size: 4rem;"></i>
            <h3 class="mt-4 mb-3">Inicia sesión para continuar</h3>
            <p class="text-muted mb-4">
              Para completar tu compra necesitas iniciar sesión o crear una cuenta.<br>
              Es rápido, seguro y te permitirá hacer seguimiento de tus pedidos.
            </p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
              <a href="../auth/login.php" class="btn btn-primary btn-lg px-5">
                <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
              </a>
              <a href="../auth/registro.php" class="btn btn-outline-primary btn-lg px-5">
                <i class="bi bi-person-plus"></i> Crear Cuenta
              </a>
            </div>
            <div class="mt-4 pt-4 border-top">
              <p class="text-muted mb-0">
                <i class="bi bi-shield-check text-success"></i> Tus datos están protegidos y seguros
              </p>
            </div>
          </div>
        </div>
      </div>
    <?php else: ?>
      <!-- Dirección de Envío -->
      <div class="col-12 col-md-6">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0"><i class="bi bi-geo-alt-fill"></i> Dirección de Envío</h5>
          </div>
          <div class="card-body">
            <p class="card-text mb-2">
              <strong><?php echo htmlspecialchars($usuario_actual->nombre . ' ' . $usuario_actual->apellidos); ?></strong>
            </p>
            <p class="card-text text-muted mb-0">
              <i class="bi bi-telephone-fill text-primary"></i> <?php echo htmlspecialchars($usuario_actual->telefono); ?><br>
              <i class="bi bi-house-fill text-primary"></i> <?php echo htmlspecialchars($usuario_actual->direccion); ?><br>
              <i class="bi bi-geo-fill text-primary"></i> <?php echo htmlspecialchars($usuario_actual->localidad . ', ' . $usuario_actual->provincia); ?><br>
            
            </p>
            <div class="mt-3 pt-3 border-top">
              <a href="../user/panel.php" class="btn btn-outline-primary btn-sm w-100">
                <i class="bi bi-pencil"></i> Modificar Dirección
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Método de Envío -->
      <div class="col-12 col-md-6">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0"><i class="bi bi-truck"></i> Método de Envío</h5>
          </div>
          <div class="card-body">
            <form method="POST" action="view.php">
              <div class="form-check mb-3 p-3 bg-light rounded">
                <input class="form-check-input" type="radio" name="metodoEnvio" id="envioEstandar" value="estandar" data-cost="<?php echo ($total_price > 50) ? '0' : '4.90'; ?>" checked>
                <label class="form-check-label w-100" for="envioEstandar">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <strong>Envío Estándar</strong><br>
                      <small class="text-muted">3-5 días hábiles</small>
                    </div>
                    <?php if($total_price > 50): ?>
                    <span class="badge bg-success">Gratis</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">4.90€</span>
                        <?php endif; ?>
                  </div>
                </label>
              </div>
              <div class="form-check mb-3 p-3 bg-light rounded">
                <input class="form-check-input" type="radio" name="metodoEnvio" id="recogidaTienda" value="tienda" data-cost="0">
                <label class="form-check-label w-100" for="recogidaTienda">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <strong>Recogida en Tienda</strong><br>
                      <small class="text-muted">Disponible en 24h</small>
                    </div>
                    <span class="badge bg-success">Gratis</span>
                  </div>
                </label>
              </div>
                <textarea name="comentarios" class="form-control d-none" rows="4"></textarea>
            </form>
          </div>
        </div>
      </div>

      <!-- Botón Continuar -->
      <div class="col-12 text-end">
        <a href="checkout_payment.php" class="btn btn-primary btn-lg px-5">
          Continuar con el Pago <i class="bi bi-arrow-right ms-2"></i>
        </a>
      </div>
    <?php endif; ?>

    </div>
  </div>

  <!-- FOOTER -->
      
  <?php include_once __DIR__ . '/../../public/partials/footer.php'; ?>

  <script src="../../public/assets/lib/scripts/cart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
