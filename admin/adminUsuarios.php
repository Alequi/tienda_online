<?php
session_start();
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__. '/../actions/usuarios_action.php';

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
            <a class="nav-link" href="javascript:history.back()">
              <i class="bi bi-arrow-left-circle"></i> Volver
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
      <div class="row mb-4">
        <div class="col-12">
          <h1 class="display-5 fw-bold"><i class="bi bi-people text-info text-primary"></i> Gestion de Usuarios</h1>
          <p class="text-muted">Crea, edita y elimina usuarios para tu tienda</p>
        </div>
      </div>

      <!-- Mensajes de error/éxito -->
      <?php if($error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="bi bi-exclamation-triangle"></i> <?php echo htmlspecialchars($error); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>
      
      <?php if($success): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="bi bi-check-circle"></i> <?php echo htmlspecialchars($success); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <!-- Tabla de usuarios -->
      <div class="row">
        <div class="col-12">
          <div class="card shadow-sm">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title fw-bold">Usuarios existentes</h5>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearUsuarioModal">
                  <i class="bi bi-plus-circle"></i> Nuevo usuario 
                </button>
                
              </div>
              <div class="table-responsive">
                <table class="table table-hover align-middle">
                  <thead class="table-light">
                    <tr>
                      <th>Dni</th>
                      <th>Nombre</th>
                      <th>Apellidos</th>
                      <th>Dirección</th>
                      <th>Localidad</th>
                      <th>Provincia</th>
                      <th>Telefono</th>
                      <th>Email</th>
                      <th>Rol</th>
                      <th>Estado</th>
                      <th class="text-end">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                      <td><span class="badge bg-secondary"><?php echo htmlspecialchars($usuario->dni); ?></span></td>
                      <td class="fw-semibold"><?php echo htmlspecialchars($usuario->nombre); ?></td>
                      <td class="text-muted"><?php echo htmlspecialchars($usuario->apellidos ?? 'Sin apellidos'); ?></td>
                        <td><?php echo htmlspecialchars($usuario->direccion ?? 'Sin dirección'); ?></td>
                        <td><?php echo htmlspecialchars($usuario->localidad ?? 'Sin localidad'); ?></td>
                        <td><?php echo htmlspecialchars($usuario->provincia ?? 'Sin provincia'); ?></td>
                        <td><?php echo htmlspecialchars($usuario->telefono ?? 'Sin teléfono'); ?></td>
                        <td><?php echo htmlspecialchars($usuario->email); ?></td>
                        <td><?php echo htmlspecialchars($usuario->rol ?? 'Sin rol'); ?></td>
                      <td>
                        <?php 
                        if($usuario->activo == 1){
                          echo '<span class="badge bg-success"><i class="bi bi-check-circle"></i> Activa</span>';
                        } else {
                          echo '<span class="badge bg-secondary"><i class="bi bi-x-circle"></i> Inactiva</span>';
                        }
                        ?>
                      </td>
                      <td class="text-end">
                        <div class="d-grid gap-2">
                          <button 
                            type="button"
                            class="btn btn-primary btn-sm editBtn w-100"
                            data-dni="<?php echo htmlspecialchars($usuario->dni); ?>"
                            data-nombre="<?php echo htmlspecialchars($usuario->nombre); ?>"
                            data-apellidos="<?php echo htmlspecialchars($usuario->apellidos ?? ''); ?>"
                            data-direccion="<?php echo htmlspecialchars($usuario->direccion ?? ''); ?>"
                            data-localidad="<?php echo htmlspecialchars($usuario->localidad ?? ''); ?>"
                            data-provincia="<?php echo htmlspecialchars($usuario->provincia ?? ''); ?>"
                            data-telefono="<?php echo htmlspecialchars($usuario->telefono ?? ''); ?>"
                            data-email="<?php echo htmlspecialchars($usuario->email); ?>"
                            data-rol="<?php echo htmlspecialchars($usuario->rol ?? ''); ?>"
                            data-activo="<?php echo $usuario->activo; ?>">
                            <i class="bi bi-pencil-square"></i> 
                          </button>
                          <a href="../actions/usuarios_action.php?action=delete&id=<?php echo $usuario->dni; ?>" class="btn btn-danger btn-sm w-100" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
                            <i class="bi bi-trash"></i> 
                          </a>
                        </div>
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

      <!-- Formulario Editar usuarios oculto -->
      <div class="row mt-4" id="datos" style="display: none;">
        <div class="col-12">
          <div class="card border-warning shadow-sm">
            <div class="card-header bg-warning bg-opacity-10 border-bottom border-warning">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-bold">
                  <i class="bi bi-pencil-square text-warning"></i> Editar usuario
                </h5>
                <button type="button" class="btn-close" onclick="document.getElementById('datos').style.display='none';" aria-label="Cerrar"></button>
              </div>
            </div>
            <div class="card-body">
              <form action="../actions/usuarios_action.php?action=edit" method="POST">
                <input type="hidden" id="editDNI" name="dni">
                
                <div class="row g-3">
                  <div class="col-md-6">
                    <label for="editNombreUsuario" class="form-label fw-semibold">Nombre</label>
                    <input type="text" class="form-control" id="editNombreUsuario" name="nombre" required>
                  </div>
                  <div class="col-md-6">
                    <label for="editApellidoUsuario" class="form-label fw-semibold">Apellidos</label>
                    <input type="text" class="form-control" id="editApellidoUsuario" name="apellidos">
                  </div>
                  <div class="col-md-6">
                    <label for="editEmailUsuario" class="form-label fw-semibold">Email</label>
                    <input type="email" class="form-control" id="editEmailUsuario" name="email" required>
                  </div>
                  <div class="col-md-6">
                    <label for="editTelefonoUsuario" class="form-label fw-semibold">Teléfono</label>
                    <input type="text" class="form-control" id="editTelefonoUsuario" name="telefono">
                  </div>
                  <div class="col-md-6">
                    <label for="editDireccionUsuario" class="form-label fw-semibold">Dirección</label>
                    <input type="text" class="form-control" id="editDireccionUsuario" name="direccion">
                  </div>
                  <div class="col-md-6">
                    <label for="editLocalidadUsuario" class="form-label fw-semibold">Localidad</label>
                    <input type="text" class="form-control" id="editLocalidadUsuario" name="localidad">
                  </div>
                  <div class="col-md-6">
                    <label for="editProvinciaUsuario" class="form-label fw-semibold">Provincia</label>
                    <input type="text" class="form-control" id="editProvinciaUsuario" name="provincia">
                  </div>
                  <div class="col-md-6">
                    <label for="editRolUsuario" class="form-label fw-semibold">Rol</label>
                    <select class="form-select" id="editRolUsuario" name="rol">
                      <option value="registrado">Registrado</option>
                      <option value="editor">Editor</option>
                      <option value="admin">Administrador</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="editActivoUsuario" class="form-label fw-semibold">Estado</label>
                    <div class="form-check form-switch mt-2">
                      <input class="form-check-input" type="checkbox" role="switch" id="editActivoUsuario" name="activoUsuario">
                      <label class="form-check-label" for="editActivoUsuario">
                        Usuario activo
                      </label>
                    </div>
                  </div>
                </div>
                
                <div class="d-flex gap-2 justify-content-end mt-3">
                  <button type="button" class="btn btn-secondary" onclick="document.getElementById('datos').style.display='none';">
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

    </div>
  </main> 

  <!-- Modal Crear usuario -->
  <div class="modal fade" id="crearUsuarioModal" tabindex="-1" aria-labelledby="crearUsuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary bg-opacity-10 border-bottom border-primary">
          <h5 class="modal-title fw-semibold" id="crearUsuarioModalLabel">
            <i class="bi bi-person-plus"></i> Crear nuevo usuario
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <form action="../actions/usarios_action.php" method="POST">
          <div class="modal-body">
            <div class="row g-3">
              <div class="col-md-6">
                <label for="dniUsuario" class="form-label fw-semibold">
                  <i class="bi bi-card-text"></i> DNI
                </label>
                <input type="text" class="form-control" id="dniUsuario" name="dni" required>
              </div>
              <div class="col-md-6">
                <label for="nombreUsuario" class="form-label fw-semibold">
                  <i class="bi bi-person"></i> Nombre
                </label>
                <input type="text" class="form-control" id="nombreUsuario" name="nombre" required>
              </div>
              <div class="col-md-6">
                <label for="apellidosUsuario" class="form-label fw-semibold">
                  <i class="bi bi-people"></i> Apellidos
                </label>
                <input type="text" class="form-control" id="apellidosUsuario" name="apellidos">
              </div>
              <div class="col-md-6">
                <label for="emailUsuario" class="form-label fw-semibold">
                  <i class="bi bi-envelope"></i> Email
                </label>
                <input type="email" class="form-control" id="emailUsuario" name="email" required>
              </div>
              <div class="col-md-6">
                <label for="telefonoUsuario" class="form-label fw-semibold">
                  <i class="bi bi-telephone"></i> Teléfono
                </label>
                <input type="text" class="form-control" id="telefonoUsuario" name="telefono">
              </div>
              <div class="col-md-6">
                <label for="passwordUsuario" class="form-label fw-semibold">
                  <i class="bi bi-key"></i> Contraseña
                </label>
                <input type="password" class="form-control" id="passwordUsuario" name="password" required>
              </div>
              <div class="col-md-12">
                <label for="direccionUsuario" class="form-label fw-semibold">
                  <i class="bi bi-geo-alt"></i> Dirección
                </label>
                <input type="text" class="form-control" id="direccionUsuario" name="direccion">
              </div>
              <div class="col-md-6">
                <label for="localidadUsuario" class="form-label fw-semibold">
                  <i class="bi bi-building"></i> Localidad
                </label>
                <input type="text" class="form-control" id="localidadUsuario" name="localidad">
              </div>
              <div class="col-md-6">
                <label for="provinciaUsuario" class="form-label fw-semibold">
                  <i class="bi bi-map"></i> Provincia
                </label>
                <input type="text" class="form-control" id="provinciaUsuario" name="provincia">
              </div>
              <div class="col-md-6">
                <label for="rolUsuario" class="form-label fw-semibold">
                  <i class="bi bi-shield-check"></i> Rol
                </label>
                <select class="form-select" id="rolUsuario" name="rol" required>
                  <option value="registrado" selected>Registrado</option>
                  <option value="editor">Editor</option>
                  <option value="admin">Administrador</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">
                  <i class="bi bi-toggle-on"></i> Estado
                </label>
                <div class="form-check form-switch mt-2">
                  <input class="form-check-input" type="checkbox" role="switch" id="activoUsuario" name="activo" checked>
                  <label class="form-check-label" for="activoUsuario">
                    Usuario activo
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
              <i class="bi bi-x-circle"></i> Cancelar
            </button>
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-check-circle"></i> Crear usuario
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- FOOTER -->
  <footer class="bg-dark text-white py-3 mt-auto">
    <div class="container-xxl text-center">
      <p class="mb-0">© 2026 Mystic Waves - Panel de Administración</p>
    </div>
  </footer>
  <script src="../public/assets/lib/scripts/users.js"></script>                    
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

