<?php
session_start();
require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__. '/../../actions/pedidos_action.php';


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

// Verificar que el usuario esté autenticado
if (!isLoggedIn()) {
  header("Location: ../auth/login.php");
  exit();
}

$con = conectar();

// Obtener datos del usuario
$stmt = $con->prepare("SELECT * FROM usuarios WHERE dni = :dni");
$stmt->bindParam(':dni', $_SESSION['user_id']);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel de Usuario | Tienda online</title>
  <link rel="icon" type="image/png" href="../../public/assets/img/logo-tienda.png" />
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

  <!-- NAVBAR + PANEL -->
  <main class="flex-grow-1">
    <div class="container-xxl my-3">
      <div class="row g-3 align-items-start">

        <!-- ZONA COMPLETA (navbar + panel) -->
        <div class="col-12">

          <!-- NAVBAR -->
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
                <li class="nav-item"><a class="nav-link" href="../tienda/nosotros.php">Sobre nosotros</a></li>
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
                        <li><a class="dropdown-item" href="panel.php"><i class="bi bi-person"></i> Perfil Personal</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="../../actions/logout_action.php"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a></li>
                      </ul>
                    </li>
                  </ul>
                <?php else: ?>
                  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="panel.php"><i class="bi bi-person"></i> Panel de usuario</a></li>
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

          <!-- PANEL DE USUARIO -->
          <div class="mt-3">
            <div class="row">
              <!-- Bienvenida -->
              <div class="col-12 mb-3">
                <div class="card border-0 shadow-sm">
                  <div class="card-body p-4">
                    <h3 class="mb-1 fw-bold"><i class="bi bi-person-circle text-primary"></i> Bienvenido, <?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellidos']); ?></h3>
                    <p class="text-muted mb-0">Gestiona tus pedidos y actualiza tu información personal</p>
                  </div>
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

              <!-- Tarjetas de acceso rápido -->
              <div class="col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100 hover-card">
                  <div class="card-body p-4 text-center">
                    <div class="mb-3">
                      <i class="bi bi-box-seam text-primary" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="card-title fw-bold">Mis Pedidos</h5>
                    <p class="card-text text-muted">Consulta el estado de tus compras y el historial completo</p>
                    <a href="#pedidos" class="btn btn-primary" id="btnVerPedidos">Ver pedidos</a>
                  </div>
                </div>
              </div>

              <div class="col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100 hover-card">
                  <div class="card-body p-4 text-center">
                    <div class="mb-3">
                      <i class="bi bi-person-gear text-primary" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="card-title fw-bold">Mis Datos</h5>
                    <p class="card-text text-muted">Actualiza tu información personal y dirección de envío</p>
                    <a href="#datos" class="btn btn-primary" id="btnVerDatos">Modificar datos</a>
                  </div>
                </div>
              </div>

              <!-- Mis Datos Personales -->
              <div class="col-12 mb-3" id="datos" style="display: none;">
                <div class="card border-0 shadow-sm">
                  <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-person-lines-fill"></i> Mis Datos Personales</h5>
                  </div>
                  <div class="card-body p-4">
                    <form method="POST" action="../../actions/usuarios_action.php?action=edit">
                      <input type="hidden" name="redirect" value="panel">
                      <div class="row g-3">
                        <div class="col-md-6">
                          <label for="nombre" class="form-label fw-semibold">Nombre</label>
                          <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>">
                        </div>
                        <div class="col-md-6">
                          <label for="apellidos" class="form-label fw-semibold">Apellidos</label>
                          <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($usuario['apellidos']); ?>">
                        </div>
                        <div class="col-md-6">
                          <label for="dni" class="form-label fw-semibold">DNI</label>
                          <input type="text" class="form-control" id="dni" name="dni" value="<?php echo htmlspecialchars($usuario['dni']); ?>" readonly>
                        </div>
                        <div class="col-md-6">
                          <label for="email" class="form-label fw-semibold">Email</label>
                          <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>">
                        </div>
                        <div class="col-md-6">
                          <label for="telefono" class="form-label fw-semibold">Teléfono</label>
                          <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo htmlspecialchars($usuario['telefono']); ?>">
                        </div>
                        <div class="col-md-6">
                          <label for="direccion" class="form-label fw-semibold">Dirección</label>
                          <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo htmlspecialchars($usuario['direccion']); ?>">
                        </div>
                        <div class="col-md-6">
                          <label for="localidad" class="form-label fw-semibold">Localidad</label>
                          <input type="text" class="form-control" id="localidad" name="localidad" value="<?php echo htmlspecialchars($usuario['localidad']); ?>">
                        </div>
                        <div class="col-md-6">
                          <label for="provincia" class="form-label fw-semibold">Provincia</label>
                          <input type="text" class="form-control" id="provincia" name="provincia" value="<?php echo htmlspecialchars($usuario['provincia']); ?>">
                        </div>
                        <div class="col-12">
                          <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Guardar cambios
                          </button>
                          <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#cambiarPasswordModal">
                            <i class="bi bi-key"></i> Cambiar contraseña
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

              <!-- Historial de Pedidos -->
              <div class="col-12" id="pedidos" style="display: none;">
                <div class="card border-0 shadow-sm">
                  <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-clock-history"></i> Historial de Pedidos</h5>
                  </div>
                  <div class="card-body p-4">
                    <?php if (empty($pedidos_usuario)): ?>
                      <!-- Mensaje si NO hay pedidos -->
                      <div class="text-center py-5">
                        <i class="bi bi-cart-x text-muted" style="font-size: 4rem;"></i>
                        <h5 class="mt-3 text-muted">Aún no has realizado ningún pedido</h5>
                        <p class="text-muted">Explora nuestra tienda y encuentra tus joyas favoritas</p>
                        <a href="../../index.php" class="btn btn-primary mt-2">
                          <i class="bi bi-shop"></i> Ir a la tienda
                        </a>
                      </div>
                    <?php else: ?>
                      <!-- Tabla de pedidos -->
                      <div class="table-responsive">
                        <table class="table table-hover">
                          <thead>
                            <tr>
                              <th>Pedido #</th>
                              <th>Fecha</th>
                              <th>Estado</th>
                              <th>Total</th>
                              <th>Acciones</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach($pedidos_usuario as $pedido_cliente): ?>
                              <tr>
                                <td>#<?php echo htmlspecialchars($pedido_cliente['idPedido']); ?></td>
                                <td><?php echo htmlspecialchars($pedido_cliente['fecha']); ?></td>
                                <td>
                                  <?php
                                  $estado = $pedido_cliente['estado'] ?? 'creado';
                                  $badgeClass = 'bg-secondary';
                                  if ($estado === 'preparado') $badgeClass = 'bg-primary';
                                  elseif ($estado === 'enviado') $badgeClass = 'bg-success';
                                  elseif ($estado === 'cancelado') $badgeClass = 'bg-danger';
                                  ?>
                                  <span class="badge <?php echo $badgeClass; ?>">
                                    <?php echo ucfirst(htmlspecialchars($estado)); ?>
                                  </span>
                                </td>
                                <td class="fw-bold">€<?php echo number_format($pedido_cliente['total'], 2); ?></td>
                                <td>
                                  <button 
                                    type="button"
                                    class="btn btn-sm btn-outline-primary" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalPedido<?php echo $pedido_cliente['idPedido']; ?>">
                                    <i class="bi bi-eye"></i> Ver detalles
                                  </button>
                                </td>
                              </tr>
                            <?php endforeach; ?>
                          </tbody>
                        </table>
                      </div>
                    <?php endif; ?> 
                  </div>
                </div>
              </div>

              <!-- Modales de detalles de pedidos -->
              <?php if (!empty($pedidos_usuario)): ?>
                <?php foreach($pedidos_usuario as $pedido_cliente): ?>
                  <div class="modal fade" id="modalPedido<?php echo $pedido_cliente['idPedido']; ?>" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">
                            <i class="bi bi-receipt"></i> Detalles del Pedido #<?php echo $pedido_cliente['idPedido']; ?>
                          </h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                          <div class="row mb-3">
                            <div class="col-md-6">
                              <strong>Fecha:</strong> <?php echo htmlspecialchars($pedido_cliente['fecha']); ?>
                            </div>
                            <div class="col-md-6">
                              <strong>Estado:</strong> 
                              <?php
                              $estado = $pedido_cliente['estado'] ?? 'creado';
                              $badgeClass = 'bg-secondary';
                              if ($estado === 'preparado') $badgeClass = 'bg-primary';
                              elseif ($estado === 'enviado') $badgeClass = 'bg-success';
                              elseif ($estado === 'cancelado') $badgeClass = 'bg-danger';
                              ?>
                              <span class="badge <?php echo $badgeClass; ?>">
                                <?php echo ucfirst(htmlspecialchars($estado)); ?>
                              </span>
                            </div>
                          </div>
                          
                          <h6 class="mt-4 mb-3">Productos del pedido:</h6>
                          <div class="table-responsive">
                            <table class="table table-sm table-striped">
                              <thead>
                                <tr>
                                  <th>Producto</th>
                                  <th class="text-center">Cantidad</th>
                                  <th class="text-end">Precio</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php 
                                $lineas_pedido_cliente = $lineas_por_pedido_user[$pedido_cliente['idPedido']] ?? [];
                                if (!empty($lineas_pedido_cliente)): 
                                ?>
                                  <?php foreach ($lineas_pedido_cliente as $linea): ?>
                                    <tr>
                                      <td><?php echo htmlspecialchars($linea['nombre']); ?></td>
                                      <td class="text-center">
                                        <span class="badge bg-info"><?php echo $linea['cantidad']; ?></span>
                                      </td>
                                      <td class="text-end">€<?php echo number_format($linea['precio'], 2); ?></td>
                                    </tr>
                                  <?php endforeach; ?>
                                <?php else: ?>
                                  <tr>
                                    <td colspan="3" class="text-center text-muted">No hay productos</td>
                                  </tr>
                                <?php endif; ?>
                              </tbody>
                              <tfoot>
                                <tr class="fw-bold">
                                  <td colspan="2" class="text-end">Total:</td>
                                  <td class="text-end">€<?php echo number_format($pedido_cliente['total'], 2); ?></td>
                                </tr>
                              </tfoot>
                            </table>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>

            </div>
          </div>

        </div><!-- /col-12 -->

      </div><!-- /row -->
    </div><!-- /container -->
  </main>

  <!-- Modal Cambiar Contraseña -->
  <div class="modal fade" id="cambiarPasswordModal" tabindex="-1" aria-labelledby="cambiarPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="cambiarPasswordModalLabel">Cambiar Contraseña</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="POST" action="../../actions/usuarios_action.php?action=change_password">
          <input type="hidden" name="dni" value="<?php echo htmlspecialchars($usuario['dni']); ?>">
          <input type="hidden" name="redirect" value="panel">
          <div class="modal-body">
            <div class="mb-3">
              <label for="currentPassword" class="form-label">Contraseña actual</label>
              <input type="password" class="form-control" id="currentPassword" name="current_password" required>
            </div>
            <div class="mb-3">
              <label for="newPassword" class="form-label">Nueva contraseña</label>
              <input type="password" class="form-control" id="newPassword" name="new_password" required>
            </div>
            <div class="mb-3">
              <label for="confirmPassword" class="form-label">Confirmar nueva contraseña</label>
              <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- FOOTER -->
  <?php include_once __DIR__ . '/../../public/partials/footer.php' ?>

  <script src="../../public/assets/lib/scripts/panel.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>