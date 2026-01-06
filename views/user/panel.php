<?php
session_start();
require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../config/conexion.php';

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
        <a href="../../index.php" class="text-decoration-none d-inline-flex align-items-center gap-2">
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
              <li class="nav-item"><a class="nav-link" href="#">Sobre nosotros</a></li>
              <li class="nav-item"><a class="nav-link" href="#">Contacto</a></li>
            </ul>

            <ul class="navbar-nav ms-auto">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle active" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="bi bi-person-circle"></i> Hola, <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                  <li><a class="dropdown-item active" href="panel.php"><i class="bi bi-person"></i> Panel de usuario</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="../../actions/logout_action.php"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a></li>
                </ul>
              </li>
            </ul>
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
                  <form>
                    <div class="row g-3">
                      <div class="col-md-6">
                        <label for="nombre" class="form-label fw-semibold">Nombre</label>
                        <input type="text" class="form-control" id="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>">
                      </div>
                      <div class="col-md-6">
                        <label for="apellidos" class="form-label fw-semibold">Apellidos</label>
                        <input type="text" class="form-control" id="apellidos" value="<?php echo htmlspecialchars($usuario['apellidos']); ?>">
                      </div>
                      <div class="col-md-6">
                        <label for="dni" class="form-label fw-semibold">DNI</label>
                        <input type="text" class="form-control" id="dni" value="<?php echo htmlspecialchars($usuario['dni']); ?>" readonly>
                      </div>
                      <div class="col-md-6">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input type="email" class="form-control" id="email" value="<?php echo htmlspecialchars($usuario['email']); ?>">
                      </div>
                      <div class="col-md-6">
                        <label for="telefono" class="form-label fw-semibold">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" value="<?php echo htmlspecialchars($usuario['telefono']); ?>">
                      </div>
                      <div class="col-md-6">
                        <label for="direccion" class="form-label fw-semibold">Dirección</label>
                        <input type="text" class="form-control" id="direccion" value="<?php echo htmlspecialchars($usuario['direccion']); ?>">
                      </div>
                      <div class="col-md-6">
                        <label for="localidad" class="form-label fw-semibold">Localidad</label>
                        <input type="text" class="form-control" id="localidad" value="<?php echo htmlspecialchars($usuario['localidad']); ?>">
                      </div>
                      <div class="col-md-6">
                        <label for="provincia" class="form-label fw-semibold">Provincia</label>
                        <input type="text" class="form-control" id="provincia" value="<?php echo htmlspecialchars($usuario['provincia']); ?>">
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
                  <!-- Mensaje si no hay pedidos -->
                  <div class="text-center py-5">
                    <i class="bi bi-cart-x text-muted" style="font-size: 4rem;"></i>
                    <h5 class="mt-3 text-muted">Aún no has realizado ningún pedido</h5>
                    <p class="text-muted">Explora nuestra tienda y encuentra tus joyas favoritas</p>
                    <a href="../../index.php" class="btn btn-primary mt-2">
                      <i class="bi bi-shop"></i> Ir a la tienda
                    </a>
                  </div>
                  
                  <!-- Ejemplo de pedido (comentado para cuando haya pedidos reales)
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
                        <tr>
                          <td>#001234</td>
                          <td>15/12/2025</td>
                          <td><span class="badge bg-success">Entregado</span></td>
                          <td>€45.99</td>
                          <td>
                            <button class="btn btn-sm btn-outline-primary">Ver detalles</button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  -->
                </div>
              </div>
            </div>

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
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="currentPassword" class="form-label">Contraseña actual</label>
            <input type="password" class="form-control" id="currentPassword" required>
          </div>
          <div class="mb-3">
            <label for="newPassword" class="form-label">Nueva contraseña</label>
            <input type="password" class="form-control" id="newPassword" required>
          </div>
          <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirmar nueva contraseña</label>
            <input type="password" class="form-control" id="confirmPassword" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary">Guardar cambios</button>
      </div>
    </div>
  </div>
</div>

<!-- FOOTER -->
<?php include_once __DIR__ . '/../../public/partials/footer.php' ?>

<script src="../../public/assets/lib/scripts/panel.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
