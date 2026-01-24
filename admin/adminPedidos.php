<?php

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../actions/products_action.php';
require_once __DIR__ . '/../actions/categorias_action.php';
require_once __DIR__ . '/../actions/pedidos_action.php';

$error = null;
$success = null;

if (isset($_SESSION['error'])) {
  $error = $_SESSION['error'];
  unset($_SESSION['error']);
}

if (isset($_SESSION['success'])) {
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
  <link rel="icon" type="image/png" href="../public/assets/img/logo-tienda.png" />
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
              <li>
                <hr class="dropdown-divider">
              </li>
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
          <h1 class="display-5 fw-bold"> <i class="bi bi-cart-check text-success" style="font-size: 4rem;"></i> Gestión de pedidos</h1>
          <p class="text-muted">Administra y revisa los pedidos realizados en la tienda</p>
        </div>
      </div>

      <!-- Mensajes de error/éxito -->
      <?php if ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="bi bi-exclamation-triangle"></i> <?php echo htmlspecialchars($error); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <?php if ($success): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="bi bi-check-circle"></i> <?php echo htmlspecialchars($success); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <!-- Tabla de pedidos -->
      <div class="row">
        <div class="col-12">
          <div class="card shadow-sm">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title fw-bold mb-0"><i class="bi bi-shop"></i> Pedidos</h5>
                <div class="input-group" style="max-width: 300px;">
                  <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                  <input type="text" id="searchInput" class="form-control" placeholder="Buscar por estado o cliente...">
                </div>
                <span class="badge bg-success text-white">Total: <?php echo count($pedidos); ?></span>
              </div>
              <div class="table-responsive">
                <table class="table table-hover align-middle" id="table">
                  <thead class="table-light">
                    <tr>
                      <th class="text-center">Fecha</th>
                      <th class="text-center">Cliente</th>
                      <th class="text-center">Total</th>
                      <th class="text-center">Estado</th>
                      <th class="text-center">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($pedidos as $pedido): ?>
                      <tr>
                        <td class="text-center"><span class="badge bg-secondary"><?php echo htmlspecialchars($pedido['fecha']); ?></span></td>
                        <td class="text-center"><?php echo htmlspecialchars($pedido['nombre']); ?></td>
                        <td class="text-center fw-semibold">€<?php echo htmlspecialchars($pedido['total']); ?></td>
                        <td class="text-center">
                          <?php
                          $estado = $pedido['estado'] ?? 'Sin estado';
                          $badgeClass = 'bg-secondary'; // Gris por defecto (creado)
                          if ($estado === 'preparado') {
                            $badgeClass = 'bg-primary'; // Azul
                          } elseif ($estado === 'enviado') {
                            $badgeClass = 'bg-success'; // Verde
                          } elseif ($estado === 'cancelado') {
                            $badgeClass = 'bg-danger'; // Rojo
                          }
                          ?>
                          <span class="badge <?php echo $badgeClass; ?>">
                            <?php echo ucfirst(htmlspecialchars($estado)); ?>
                          </span>
                        </td>
                        <td class="text-center">
                          <button
                            type="button"
                            class="btn btn-primary btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#modalPedido<?php echo $pedido['idPedido']; ?>">
                            <i class="bi bi-pencil-square"></i> Ver detalles
                          </button>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Modales para cada pedido -->
      <?php foreach ($pedidos as $pedido): ?>
        <div class="modal fade" id="modalPedido<?php echo $pedido['idPedido']; ?>" tabindex="-1">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header bg-warning bg-opacity-10">
                <h5 class="modal-title fw-bold">
                  <i class="bi bi-pencil-square text-warning"></i> Detalles del Pedido #<?php echo $pedido['idPedido']; ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <form action="../actions/pedidos_action.php?action=updateEstado" method="POST">
                  <input type="hidden" name="idPedido" value="<?php echo $pedido['idPedido']; ?>">

                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label class="form-label fw-semibold">
                        <i class="bi bi-calendar3"></i> Fecha
                      </label>
                      <input type="text" class="form-control" value="<?php echo htmlspecialchars($pedido['fecha']); ?>" readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                      <label class="form-label fw-semibold">
                        <i class="bi bi-person"></i> Cliente
                      </label>
                      <input type="text" class="form-control" value="<?php echo htmlspecialchars($pedido['nombre']); ?>" readonly>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label class="form-label fw-semibold">
                        <i class="bi bi-cash-coin"></i> Total
                      </label>
                      <input type="text" class="form-control" value="€<?php echo htmlspecialchars($pedido['total']); ?>" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label fw-semibold">
                        <i class="bi bi-toggle-on"></i> Estado
                      </label>
                      <select class="form-select" name="estadoPedido" required>
                        <option value="creado" <?php echo ($pedido['estado'] ?? '') === 'creado' ? 'selected' : ''; ?>>Creado</option>
                        <option value="preparado" <?php echo ($pedido['estado'] ?? '') === 'preparado' ? 'selected' : ''; ?>>Preparado</option>
                        <option value="enviado" <?php echo ($pedido['estado'] ?? '') === 'enviado' ? 'selected' : ''; ?>>Enviado</option>
                        <option value="cancelado" <?php echo ($pedido['estado'] ?? '') === 'cancelado' ? 'selected' : ''; ?>>Cancelado</option>
                      </select>
                    </div>
                  </div>

                  <!-- Dirección de envío -->
                  <div class="mb-3">
                    <label class="form-label fw-semibold">
                      <i class="bi bi-geo-alt-fill text-primary"></i> Dirección de Envío
                    </label>
                    <div class="card bg-light border-0">
                      <div class="card-body">
                        <div class="row g-2">
                          <div class="col-md-12">
                            <small class="text-muted">Dirección:</small>
                            <p class="mb-1 fw-medium"><?php echo htmlspecialchars($pedido['user_direccion'] ?? 'No especificada'); ?></p>
                          </div>
                          <div class="col-md-6">
                            <small class="text-muted">Localidad:</small>
                            <p class="mb-1"><?php echo htmlspecialchars($pedido['user_localidad'] ?? 'No especificada'); ?></p>
                          </div>
                          <div class="col-md-6">
                            <small class="text-muted">Provincia:</small>
                            <p class="mb-1"><?php echo htmlspecialchars($pedido['user_provincia'] ?? 'No especificada'); ?></p>
                          </div>
                          <div class="col-md-12">
                            <small class="text-muted">Teléfono:</small>
                            <p class="mb-0"><?php echo htmlspecialchars($pedido['user_telefono'] ?? 'No especificado'); ?></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="mb-3">
                    <label class="form-label fw-semibold">
                      <i class="bi bi-box-seam"></i> Productos del pedido
                    </label>
                    <div class="table-responsive">
                      <table class="table table-sm table-striped table-hover align-middle">
                        <thead class="table-light">
                          <tr>
                            <th>Producto</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-end">Precio Unitario</th>
                          </tr>
                        </thead>
                        <tbody>

                          <?php
                          $lineas_pedido = $lineas_por_pedido[$pedido['idPedido']] ?? [];
                          
                          ?>
                            <?php foreach ($lineas_pedido as $linea): ?>
                              <tr>
                                <td><?php echo htmlspecialchars($linea['nombre']); ?></td>
                                <td class="text-center">
                                  <span class="badge bg-info"><?php echo htmlspecialchars($linea['cantidad']); ?></span>
                                </td>
                                <td class="text-end fw-semibold">€<?php echo number_format($linea['precio'], 2); ?></td>
                              </tr>
                            <?php endforeach; ?>
                        
                        </tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>

                  <div class="d-flex gap-2 justify-content-end">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                      <i class="bi bi-x-circle"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                      <i class="bi bi-check-circle"></i> Guardar cambios
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

    </div>
  </main>



  <!-- FOOTER -->
  <footer class="bg-dark text-white py-3 mt-auto">
    <div class="container-xxl text-center">
      <p class="mb-0">© 2026 Mystic Waves - Panel de Administración</p>
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../public/assets/lib/scripts/filter.js"></script>
</body>

</html>