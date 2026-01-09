<?php
session_start();
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__. '/../actions/products_action.php';

// Verificar que el usuario esté logeado y sea administrador
if (!isLoggedIn()) {
    header("Location: ../views/auth/login.php");
    exit();
}

requireAdmin();


$nombre_admin = $_SESSION['user_name'] ?? 'Administrador';
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel de Administración | Tienda Online</title>
  <link rel="icon" type="image/png" href="../public/assets/img/logo-tienda.png"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link href="../public/assets/css/style.css" rel="stylesheet">
</head>

<body class="bg-light d-flex flex-column min-vh-100">

  <!-- NAVBAR ADMIN -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="adminPanel.php">
        <i class="bi bi-speedometer2"></i> Panel de Administración
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarAdmin">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="../index.php">
              <i class="bi bi-house-door"></i> Ir a la tienda
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
              <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($nombre_admin); ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="../views/user/panel.php"><i class="bi bi-person"></i> Mi perfil</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="../actions/logout_action.php"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- MAIN CONTENT -->
  <main class="flex-grow-1">
    <div class="container-xxl my-5">
      
      <!-- Header -->
      <div class="row mb-4">
        <div class="col-12">
          <h1 class="display-5 fw-bold"><i class="bi bi-speedometer2 text-primary"></i> Panel de Administración</h1>
          <p class="text-muted">Gestiona tu tienda online desde aquí</p>
        </div>
      </div>

      <!-- Estadísticas rápidas -->
      <div class="row g-4 mb-5">
        <div class="col-md-3">
          <div class="card border-0 shadow-sm text-center h-100">
            <div class="card-body">
              <i class="bi bi-box-seam text-primary" style="font-size: 3rem;"></i>
              <h3 class="mt-3 mb-0"><?php echo $total_productos; ?></h3>
              <p class="text-muted mb-0">Productos</p>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card border-0 shadow-sm text-center h-100">
            <div class="card-body">
              <i class="bi bi-cart-check text-success" style="font-size: 3rem;"></i>
              <h3 class="mt-3 mb-0">--</h3>
              <p class="text-muted mb-0">Pedidos</p>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card border-0 shadow-sm text-center h-100">
            <div class="card-body">
              <i class="bi bi-people text-info" style="font-size: 3rem;"></i>
              <h3 class="mt-3 mb-0">--</h3>
              <p class="text-muted mb-0">Usuarios</p>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card border-0 shadow-sm text-center h-100">
            <div class="card-body">
              <i class="bi bi-tags text-warning" style="font-size: 3rem;"></i>
              <h3 class="mt-3 mb-0"><?php echo $suma_categorias; ?></h3>
              <p class="text-muted mb-0">Categorías</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Opciones de gestión -->
      <div class="row g-4">
        
        <!-- Gestión de Productos -->
        <div class="col-md-6 col-lg-3">
          <div class="card border-0 shadow-sm h-100 hover-card">
            <div class="card-body text-center p-4">
              <div class="mb-3">
                <i class="bi bi-box-seam text-primary" style="font-size: 4rem;"></i>
              </div>
              <h5 class="card-title fw-bold">Productos</h5>
              <p class="card-text text-muted">Alta, baja y modificación de productos</p>
              <a href="#" class="btn btn-primary mt-2">
                <i class="bi bi-arrow-right-circle"></i> Gestionar
              </a>
            </div>
          </div>
        </div>

        <!-- Gestión de Categorías -->
        <div class="col-md-6 col-lg-3">
          <div class="card border-0 shadow-sm h-100 hover-card">
            <div class="card-body text-center p-4">
              <div class="mb-3">
                <i class="bi bi-tags text-warning" style="font-size: 4rem;"></i>
              </div>
              <h5 class="card-title fw-bold">Categorías</h5>
              <p class="card-text text-muted">Administrar categorías de productos</p>
              <a href="adminCategoria.php" class="btn btn-warning mt-2">
                <i class="bi bi-arrow-right-circle"></i> Gestionar
              </a>
            </div>
          </div>
        </div>

        <!-- Gestión de Pedidos -->
        <div class="col-md-6 col-lg-3">
          <div class="card border-0 shadow-sm h-100 hover-card">
            <div class="card-body text-center p-4">
              <div class="mb-3">
                <i class="bi bi-cart-check text-success" style="font-size: 4rem;"></i>
              </div>
              <h5 class="card-title fw-bold">Pedidos</h5>
              <p class="card-text text-muted">Ver y gestionar pedidos de clientes</p>
              <a href="#" class="btn btn-success mt-2">
                <i class="bi bi-arrow-right-circle"></i> Gestionar
              </a>
            </div>
          </div>
        </div>

        <!-- Gestión de Usuarios -->
        <div class="col-md-6 col-lg-3">
          <div class="card border-0 shadow-sm h-100 hover-card">
            <div class="card-body text-center p-4">
              <div class="mb-3">
                <i class="bi bi-people text-info" style="font-size: 4rem;"></i>
              </div>
              <h5 class="card-title fw-bold">Usuarios</h5>
              <p class="card-text text-muted">Gestión de clientes registrados</p>
              <a href="#" class="btn btn-info mt-2">
                <i class="bi bi-arrow-right-circle"></i> Gestionar
              </a>
            </div>
          </div>
        </div>

      </div>

      <!-- Sección de actividad reciente (opcional) -->
      <div class="row mt-5">
        <div class="col-12">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
              <h5 class="mb-0"><i class="bi bi-clock-history"></i> Actividad Reciente</h5>
            </div>
            <div class="card-body">
              <div class="text-center py-4 text-muted">
                <i class="bi bi-info-circle" style="font-size: 2rem;"></i>
                <p class="mt-2">No hay actividad reciente para mostrar</p>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </main>

  <!-- FOOTER -->
  <footer class="bg-dark text-white py-3 mt-auto">
    <div class="container-xxl text-center">
      <p class="mb-0">© 2026 Mystic Waves - Panel de Administración</p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
