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
          <h1 class="display-5 fw-bold"><i class="bi bi-tags text-warning text-primary"></i> Gestion de Categorías</h1>
          <p class="text-muted">Crea, edita y elimina categorías para organizar tus productos</p>
        </div>
      </div>

      <!-- Tabla de categorías -->
      <div class="row">
        <div class="col-12">
          <div class="card shadow-sm">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title fw-bold">Categorías Existentes</h5>
                <a href="adminCategoriaCrear.php" class="btn btn-success">
                  <i class="bi bi-plus-circle"></i> Nueva Categoría
                </a>  
              </div>
              <div><table class="table table-hover">
                <thead>
                  <tr>
                    <th>Codigo</th>
                    <th>Nombre</th>
                    <th>Disponibilidad</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($categorias as $categoria): ?>
                  <tr>
                    <td><?php echo htmlspecialchars($categoria->codigo); ?></td>
                    <td><?php echo htmlspecialchars($categoria->nombre); ?></td>
                    <td>
                      <?php 
                      if($categoria->activo == 1){
                        echo '<span class="badge bg-success">Activa</span>';
                      } else {
                        echo '<span class="badge bg-secondary">Inactiva</span>';
                      }
                      ?>
                    </td>
                    <td>
                      <a href="adminCategoriaEditar.php?id=<?php echo $categoria->id; ?>" class="btn btn-primary btn-sm">
                        <i class="bi bi-pencil-square"></i> Editar
                      </a>
                      <a href="adminCategoriaEliminar.php?id=<?php echo $categoria->id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar esta categoría?');">
                        <i class="bi bi-trash"></i> Eliminar
                      </a>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
              


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



