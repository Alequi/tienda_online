<?php
session_start();
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__. '/../actions/products_action.php';
require_once __DIR__. '/../actions/categorias_action.php';

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
          <h1 class="display-5 fw-bold"><i class="bi bi-tags text-warning text-primary"></i> Gestion de categorías</h1>
          <p class="text-muted">Crea, edita y elimina categorías para organizar tus productos</p>
        </div>
      </div>

      <!-- Tabla de categorías -->
      <div class="row">
        <div class="col-12">
          <div class="card shadow-sm">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title fw-bold">Categorías existentes</h5>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearCategoriaModal">
                  <i class="bi bi-plus-circle"></i> Nueva categoría 
                </button>
                
              </div>
              <div class="table-responsive">
                <table class="table table-hover align-middle">
                  <thead class="table-light">
                    <tr>
                      <th>Código</th>
                      <th>Nombre</th>
                      <th>Descripción</th>
                      <th>Estado</th>
                      <th class="text-end">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($categorias as $categoria): ?>
                    <tr>
                      <td><span class="badge bg-secondary"><?php echo htmlspecialchars($categoria->codigo); ?></span></td>
                      <td class="fw-semibold"><?php echo htmlspecialchars($categoria->nombre); ?></td>
                      <td class="text-muted"><?php echo htmlspecialchars($categoria->descripcion ?? 'Sin descripción'); ?></td>
                      <td>
                        <?php 
                        if($categoria->activo == 1){
                          echo '<span class="badge bg-success"><i class="bi bi-check-circle"></i> Activa</span>';
                        } else {
                          echo '<span class="badge bg-secondary"><i class="bi bi-x-circle"></i> Inactiva</span>';
                        }
                        ?>
                      </td>
                      <td class="text-end">
                        <button 
                          type="button"
                          class="btn btn-primary btn-sm editBtn"
                          data-codigo="<?php echo htmlspecialchars($categoria->codigo); ?>"
                          data-nombre="<?php echo htmlspecialchars($categoria->nombre); ?>"
                          data-descripcion="<?php echo htmlspecialchars($categoria->descripcion ?? ''); ?>"
                          data-activo="<?php echo $categoria->activo; ?>">
                          <i class="bi bi-pencil-square"></i> Editar
                        </button>
                        <a href="../actions/categorias_action.php?action=delete&id=<?php echo $categoria->codigo; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar esta categoría?');">
                          <i class="bi bi-trash"></i> Eliminar
                        </a>
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

      <!-- Formulario Editar categoría oculto -->
      <div class="row mt-4" id="datos" style="display: none;">
        <div class="col-12">
          <div class="card border-warning shadow-sm">
            <div class="card-header bg-warning bg-opacity-10 border-bottom border-warning">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-bold">
                  <i class="bi bi-pencil-square text-warning"></i> Editar categoría
                </h5>
                <button type="button" class="btn-close" onclick="document.getElementById('datos').style.display='none';" aria-label="Cerrar"></button>
              </div>
            </div>
            <div class="card-body">
              <form action="../actions/categorias_action.php?action=edit" method="POST">
                <input type="hidden" id="editCodigo" name="codigo">
                
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="editNombreCategoria" class="form-label fw-semibold">
                      <i class="bi bi-tag"></i> Nombre de la Categoría
                    </label>
                    <input type="text" class="form-control" id="editNombreCategoria" name="nombreCategoria" required>
                  </div>
                  
                  <div class="col-md-6 mb-3">
                    <label for="editActivoCategoria" class="form-label fw-semibold">
                      <i class="bi bi-toggle-on"></i> Estado
                    </label>
                    <div class="form-check form-switch mt-2">
                      <input class="form-check-input" type="checkbox" role="switch" id="editActivoCategoria" name="activoCategoria">
                      <label class="form-check-label" for="editActivoCategoria">
                        Categoría activa
                      </label>
                    </div>
                  </div>
                </div>
                
                <div class="mb-3">
                  <label for="editDescripcionCategoria" class="form-label fw-semibold">
                    <i class="bi bi-text-paragraph"></i> Descripción
                  </label>
                  <textarea class="form-control" id="editDescripcionCategoria" name="descripcionCategoria" rows="3" placeholder="Descripción opcional de la categoría"></textarea>
                </div>
                
                <div class="d-flex gap-2 justify-content-end">
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

  <!-- Modal Crear Categoría -->
  <div class="modal fade" id="crearCategoriaModal" tabindex="-1" aria-labelledby="crearCategoriaModalLabel" aria-hidden="true">
    <div class="modal-dialog border-warning shadow-sm">
      <div class="modal-content border-warning shadow-sm">
        <div class="modal-header bg-primary bg-opacity-10 border-bottom border-primary">
          <h5 class="modal-title fw-semibold" id="crearCategoriaModalLabel">Crear nueva categoría</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <form action="../actions/categorias_action.php" method="POST">
          <div class="modal-body">
            <div class="mb-3">
              <label for="nombreCategoria" class="form-label"><i class="bi bi-tag"></i>Nombre de la Categoría</label>
              <input type="text" class="form-control" id="nombreCategoria" name="nombreCategoria" required>
            </div>
            <div class="mb-3">
              <label for="descripcionCategoria" class="form-label"><i class="bi bi-text-paragraph"></i> Descripción</label>
              <textarea class="form-control" id="descripcionCategoria" name="descripcionCategoria" rows="3"></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label"><i class="bi bi-toggle-on"></i> Estado</label>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="activoCategoria" name="activoCategoria" checked>
                <label class="form-check-label" for="activoCategoria">
                  Categoría activa
                </label>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Crear </button>
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
  <script src="../public/assets/lib/scripts/categorie.js"></script>                    
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



