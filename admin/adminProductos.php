<?php
session_start();
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../actions/products_action.php';
require_once __DIR__ . '/../actions/categorias_action.php';


// Verificar que el usuario esté logeado y sea administrador
if (!isLoggedIn()) {
  header("Location: ../views/auth/login.php");
  exit();
}

requireEditorOrAdmin();

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
          <h1 class="display-5 fw-bold"><i class="bi bi-box-seam text-primary"></i> Gestión de productos</h1>
          <p class="text-muted">Crea, edita y elimina productos para tu tienda</p>
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

      <!-- Tabla de productos -->
      <div class="row">
        <div class="col-12">
          <div class="card shadow-sm">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title fw-bold">Productos existentes</h5>
                <div class="input-group" style="max-width: 300px;">
                  <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                  <input type="text" id="searchInput" class="form-control" placeholder="Buscar por nombre o categoria...">
                </div>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearProductoModal">
                  <i class="bi bi-plus-circle"></i> Nuevo producto
                </button>

              </div>
              <div class="table-responsive">
                <table class="table table-hover align-middle" id="table">
                  <thead class="table-light">
                    <tr>
                      <th>Código</th>
                      <th>Nombre</th>
                      <th>Descripción</th>
                      <th>Categoría</th>
                      <th>Stock</th>
                      <th>Precio</th>
                      <th>Precio Anterior</th>
                      <th>Imagen</th>
                      <th>Estado</th>
                      <th class="text-end">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($productos as $producto): ?>
                      <tr>
                        <td><span class="badge bg-secondary"><?php echo htmlspecialchars($producto->codigo); ?></span></td>
                        <td class="fw-semibold"><?php echo htmlspecialchars($producto->nombre); ?></td>
                        <td class="text-muted"><?php
                                                $descripcion = $producto->descripcion ?? 'Sin descripción';
                                                echo htmlspecialchars(strlen($descripcion) > 50 ? substr($descripcion, 0, 50) . '...' : $descripcion);
                                                ?></td>
                        <td>
                          <?php
                          $categoria_nombre = 'Sin categoría';
                          foreach ($total_categorias as $categoria) {
                            if ($categoria->codigo == $producto->categoria) {
                              $categoria_nombre = $categoria->nombre;
                              break;
                            }
                          }
                          echo htmlspecialchars($categoria_nombre);
                          ?>
                        </td>
                        <td><?php echo intval($producto->stock); ?></td>
                        <td> <?php echo number_format($producto->precio, 2) . '€'; ?></td>
                        <td>
                          <?php
                          if($producto->precio_anterior){
                            echo   number_format($producto->precio_anterior, 2) . '€';
                          } else {
                            echo '<span class="text-muted">N/A</span>';
                          }
                          ?>
                        </td>
                        <td>
                          <?php
                          if ($producto->imagen) {
                            echo '<img src="../public/assets/img/' . htmlspecialchars($producto->imagen) . '" alt="' . htmlspecialchars($producto->nombre) . '" class="img-thumbnail" style="max-width: 60px; height: auto;">';
                          } else {
                            echo '<span class="text-muted">Sin imagen</span>';
                          }
                          ?>
                        </td>

                        <td>
                          <?php
                          if ($producto->activo == 1) {
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
                            class="btn btn-primary btn-sm editBtn"
                            data-codigo="<?php echo htmlspecialchars($producto->codigo); ?>"
                            data-nombre="<?php echo htmlspecialchars($producto->nombre); ?>"
                            data-descripcion="<?php echo htmlspecialchars($producto->descripcion ?? ''); ?>"
                            data-precio="<?php echo $producto->precio; ?>"
                            data-precio-anterior="<?php echo $producto->precio_anterior ?? ''; ?>"
                            data-stock="<?php echo $producto->stock; ?>"
                            data-categoria="<?php echo $producto->categoria ?? ''; ?>"
                            data-imagen="<?php echo htmlspecialchars($producto->imagen ?? ''); ?>"
                            data-activo="<?php echo $producto->activo; ?>">
                            <i class="bi bi-pencil-square"></i> 
                          </button>
                          <a href="../actions/products_action.php?action=delete&id=<?php echo $producto->codigo; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
                            <i class="bi bi-trash"></i> 
                          </a>
                          </div>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
              
              <!-- Paginación -->
              <?php if ($total_paginas > 1): ?>
              <nav aria-label="Navegación de productos" class="mt-4">
                <ul class="pagination justify-content-center">
                  
                  <!-- Botón Anterior -->
                  <li class="page-item <?php echo ($pagina_actual <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?pagina=<?php echo $pagina_actual - 1; ?>" aria-label="Anterior">
                      <span aria-hidden="true">&laquo;</span>
                    </a>
                  </li>

                  <!-- Números de página -->
                  <?php
                  $rango = 2;
                  $inicio = max(1, $pagina_actual - $rango);
                  $fin = min($total_paginas, $pagina_actual + $rango);

                  if ($inicio > 1) {
                    echo '<li class="page-item"><a class="page-link" href="?pagina=1">1</a></li>';
                    if ($inicio > 2) {
                      echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                    }
                  }

                  for ($i = $inicio; $i <= $fin; $i++): ?>
                    <li class="page-item <?php echo ($i == $pagina_actual) ? 'active' : ''; ?>">
                      <a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                  <?php endfor;

                  if ($fin < $total_paginas) {
                    if ($fin < $total_paginas - 1) {
                      echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                    }
                    echo '<li class="page-item"><a class="page-link" href="?pagina=' . $total_paginas . '">' . $total_paginas . '</a></li>';
                  }
                  ?>

                  <!-- Botón Siguiente -->
                  <li class="page-item <?php echo ($pagina_actual >= $total_paginas) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?pagina=<?php echo $pagina_actual + 1; ?>" aria-label="Siguiente">
                      <span aria-hidden="true">&raquo;</span>
                    </a>
                  </li>
                  
                </ul>
                
                <!-- Info de paginación -->
                <p class="text-center text-muted small">
                  Mostrando <?php echo $offset + 1; ?> - <?php echo min($offset + $registros_por_pagina, $total_productos); ?> 
                  de <?php echo $total_productos; ?> productos
                </p>
              </nav>
              <?php endif; ?>

            </div>
          </div>
        </div>
      </div>

      <!-- Formulario Editar producto oculto -->
      <div class="row mt-4" id="datos" style="display: none;">
        <div class="col-12">
          <div class="card border-warning shadow-sm">
            <div class="card-header bg-warning bg-opacity-10 border-bottom border-warning">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-bold">
                  <i class="bi bi-pencil-square text-warning"></i> Editar producto
                </h5>
                <button type="button" class="btn-close" onclick="document.getElementById('datos').style.display='none';" aria-label="Cerrar"></button>
              </div>
            </div>
            <div class="card-body">
              <form action="../actions/products_action.php?action=edit" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="editCodigo" name="codigo">

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="editNombre" class="form-label fw-semibold">
                      <i class="bi bi-tag"></i> Nombre del Producto
                    </label>
                    <input type="text" class="form-control" id="editNombre" name="nombre" required>
                  </div>

                  <div class="col-md-6 mb-3">
                    <label for="editCategoria" class="form-label fw-semibold">
                      <i class="bi bi-folder"></i> Categoría
                    </label>
                    <select class="form-select" id="editCategoria" name="categoria" required>
                      <option value="">Seleccionar categoría</option>
                      <?php foreach ($total_categorias as $categoria): ?>
                        <option value="<?php echo htmlspecialchars($categoria->codigo); ?>">
                          <?php echo htmlspecialchars($categoria->nombre); ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4 mb-3">
                    <label for="editPrecio" class="form-label fw-semibold">
                      <i class="bi bi-currency-euro"></i> Precio
                    </label>
                    <input type="number" step="0.01" class="form-control" id="editPrecio" name="precio" required>
                  </div>

                  <div class="col-md-4 mb-3">
                    <label for="editPrecioAnterior" class="form-label fw-semibold">
                      <i class="bi bi-currency-euro"></i> Precio Anterior
                    </label>
                    <input type="number" step="0.01" class="form-control" id="editPrecioAnterior" name="precio_anterior">
                  </div>

                  <div class="col-md-4 mb-3">
                    <label for="editStock" class="form-label fw-semibold">
                      <i class="bi bi-box"></i> Stock
                    </label>
                    <input type="number" class="form-control" id="editStock" name="stock" required>
                  </div>
                </div>

                <div class="mb-3">
                  <label for="editDescripcion" class="form-label fw-semibold">
                    <i class="bi bi-text-paragraph"></i> Descripción
                  </label>
                  <textarea class="form-control" id="editDescripcion" name="descripcion" rows="3" placeholder="Descripción del producto"></textarea>
                </div>

                <div class="row">
                  <div class="col-md-8 mb-3">
                    <label for="editImagen" class="form-label fw-semibold">
                      <i class="bi bi-image"></i> Imagen
                    </label>
                    <input type="file" class="form-control" id="editImagen" name="imagen" accept="image/*">
                    <div class="mt-2" id="previewImageContainer" style="display: none;">
                      <small class="text-muted d-block mb-1" id="imagenActual"></small>
                      <img id="previewImage" src="" alt="Vista previa" class="img-thumbnail" style="max-width: 200px; height: auto;">
                    </div>
                  </div>

                  <div class="col-md-4 mb-3">
                    <label for="editActivo" class="form-label fw-semibold">
                      <i class="bi bi-toggle-on"></i> Estado
                    </label>
                    <div class="form-check form-switch mt-2">
                      <input class="form-check-input" type="checkbox" role="switch" id="editActivo" name="activo">
                      <label class="form-check-label" for="editActivo">
                        Producto activo
                      </label>
                    </div>
                  </div>
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

  <!-- Modal Crear Producto -->
  <div class="modal fade" id="crearProductoModal" tabindex="-1" aria-labelledby="crearProductoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg border-warning shadow-sm">
      <div class="modal-content border-warning shadow-sm">
        <div class="modal-header bg-primary bg-opacity-10 border-bottom border-primary">
          <h5 class="modal-title fw-semibold" id="crearProductoModalLabel">Crear nuevo producto</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <form action="../actions/products_action.php" method="POST" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="row">
                        <div class="col-md-2 mb-3">
                <label for="codigo" class="form-label"><i class="bi bi-123"></i> Codigo</label>
                <input type="text" class="form-control" id="codigo" name="codigo" required>
              </div>

              <div class="col-md-5 mb-3">
                <label for="nombre" class="form-label"><i class="bi bi-tag"></i> Nombre del Producto</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
              </div>
              <div class="col-md-5 mb-3">
                <label for="categoria" class="form-label"><i class="bi bi-folder"></i> Categoría</label>
                <select class="form-select" id="categoria" name="categoria" required>
                  <option value="">Seleccionar categoría</option>
                  <?php foreach ($total_categorias as $categoria): ?>
                    <option value="<?php echo htmlspecialchars($categoria->codigo); ?>">
                      <?php echo htmlspecialchars($categoria->nombre); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-4 mb-3">
                <label for="precio" class="form-label"><i class="bi bi-currency-euro"></i> Precio</label>
                <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
              </div>
              <div class="col-md-4 mb-3">
                <label for="precio_anterior" class="form-label"><i class="bi bi-currency-euro"></i> Precio Anterior</label>
                <input type="number" step="0.01" class="form-control" id="precio_anterior" name="precio_anterior">
              </div>
              <div class="col-md-4 mb-3">
                <label for="stock" class="form-label"><i class="bi bi-box"></i> Stock</label>
                <input type="number" class="form-control" id="stock" name="stock" required>
              </div>
            </div>

            <div class="mb-3">
              <label for="descripcion" class="form-label"><i class="bi bi-text-paragraph"></i> Descripción</label>
              <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
            </div>

            <div class="row">
              <div class="col-md-8 mb-3">
                <label for="imagen" class="form-label"><i class="bi bi-image"></i> Imagen</label>
                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label"><i class="bi bi-toggle-on"></i> Estado</label>
                <div class="form-check form-switch mt-2">
                  <input class="form-check-input" type="checkbox" role="switch" id="activo" name="activo" checked>
                  <label class="form-check-label" for="activo">
                    Producto activo
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Crear</button>
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../public/assets/lib/scripts/product.js"></script>
  <script src="../public/assets/lib/scripts/filter.js"></script>
</body>

</html>