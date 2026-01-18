<?php
session_start();
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__. '/../actions/informes_action.php';

$error = null;
$success = null;

if(isset($_SESSION['error'])){
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}

if(isset($_SESSION['success'])){
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
}

// Verificar que el usuario esté logeado y sea administrador
if (!isLoggedIn()) {
    header("Location: ../views/auth/login.php");
    exit();
}

requireEditorOrAdmin();


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
  <nav class="navbar navbar-expand-lg navbar-light bg-dark shadow-sm">
    <div class="container-fluid">
      
      <a class="navbar-brand fw-bold text-white" href="adminPanel.php">
        <i class="bi bi-speedometer2"></i> Panel de Administración
      </a>
      
      <button class="navbar-toggler border-warning" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarAdmin">
  
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="adminPanel.php">
              <i class="bi bi-arrow-left-circle"></i> Volver al panel
            </a>
          </li>
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
       <!-- MAIN CONTENT -->
  <main class="flex-grow-1">
    <div class="container-xxl my-5">

    <!-- Header -->
      <div class="row mb-4">
        <div class="col-12">
          <h1 class="display-5 fw-bold"><i class="bi bi-file-earmark-bar-graph text-danger"></i> Informes y estadísticas</h1>
          <p class="text-muted">Estadísticas y reportes de ventas</p>
        </div>
      </div>

      <!-- Cards de estadísticas - Fila superior -->
      <div class="row g-4 mb-4">
        
        <!-- Total ventas últimos 7 días -->
        <div class="col-md-4">
          <div class="card border-0 shadow-sm stat-card h-100">
            <div class="card-body text-center py-4">
              <div class="mb-3">
                <i class="bi bi-calendar-week text-success" style="font-size: 3.5rem;"></i>
              </div>
              <p class="text-muted text-uppercase small fw-semibold mb-2">Últimos 7 días</p>
              <h2 class="display-4 fw-bold text-success mb-2">
                <?php echo number_format($total_ventas_7dias, 2); ?>€
              </h2>
              <small class="text-muted">Total de ventas completadas</small>
            </div>
          </div>
        </div>

        <!-- Total ventas últimos 30 días -->
        <div class="col-md-4">
          <div class="card border-0 shadow-sm stat-card h-100">
            <div class="card-body text-center py-4">
              <div class="mb-3">
                <i class="bi bi-calendar-month text-primary" style="font-size: 3.5rem;"></i>
              </div>
              <p class="text-muted text-uppercase small fw-semibold mb-2">Últimos 30 días</p>
              <h2 class="display-4 fw-bold text-primary mb-2">
                <?php echo number_format($total_ventas_30dias, 2); ?>€
              </h2>
              <small class="text-muted">Ventas del mes actual</small>
            </div>
          </div>
        </div>

        <!-- Total ventas últimos 12 meses -->
        <div class="col-md-4">
          <div class="card border-0 shadow-sm stat-card h-100">
            <div class="card-body text-center py-4">
              <div class="mb-3">
                <i class="bi bi-calendar-range text-info" style="font-size: 3.5rem;"></i>
              </div>
              <p class="text-muted text-uppercase small fw-semibold mb-2">Últimos 12 meses</p>
              <h2 class="display-4 fw-bold text-info mb-2">
                <?php echo number_format($total_ventas_12meses, 2); ?>€
              </h2>
              <small class="text-muted">Ventas anuales acumuladas</small>
            </div>
          </div>
        </div>

      </div>

      <!-- Productos más vendidos - Fila inferior -->
      <div class="row">
        <div class="col-12">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-warning bg-opacity-25 border-bottom border-warning py-3">
              <h5 class="mb-0 text-dark fw-semibold">
                <i class="bi bi-trophy-fill"></i> Top productos más vendidos
              </h5>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive table-scroll">
                <table class="table table-hover mb-0 align-middle">
                  <thead class="table-light">
                    <tr>
                      <th class="ps-4" style="width: 80px;">Posición</th>
                      <th style="width: 130px;">Código</th>
                      <th>Producto</th>
                      <th class="text-end pe-4" style="width: 140px;">Cantidad</th>
                    </tr>
                  </thead>
                  <tbody>
                  <tbody>
                    <?php if (!empty($productos_mas_vendidos)): ?>
                      <?php foreach ($productos_mas_vendidos as $index => $producto): ?>
                        <tr>
                          <td class="ps-4">
                            <?php if ($index === 0): ?>
                              <span class="badge bg-warning text-dark px-2 py-1">
                                <i class="bi bi-trophy-fill"></i> 1º
                              </span>
                            <?php elseif ($index === 1): ?>
                              <span class="badge bg-secondary px-2 py-1">
                                <i class="bi bi-trophy-fill"></i> 2º
                              </span>
                            <?php elseif ($index === 2): ?>
                              <span class="badge px-2 py-1" style="background-color: #cd7f32; color: white;">
                                <i class="bi bi-trophy-fill"></i> 3º
                              </span>
                            <?php else: ?>
                              <span class="text-muted fw-semibold"><?php echo $index + 1; ?>º</span>
                            <?php endif; ?>
                          </td>
                          <td>
                            <span class="badge bg-dark">
                              <?php echo htmlspecialchars($producto['codigo']); ?>
                            </span>
                          </td>
                          <td class="fw-medium"><?php echo htmlspecialchars($producto['nombre']); ?></td>
                          <td class="text-end pe-4">
                            <span class="badge bg-primary">
                              <?php echo $producto['total_vendido']; ?> uds
                            </span>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                          <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                          No hay datos disponibles
                        </td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
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
  <script src="../public/assets/lib/scripts/categorie.js"></script>                    
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


