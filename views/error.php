<?php
session_start();
$errorMessage = $_SESSION['error'] ?? 'Ha ocurrido un error inesperado.';
unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error | Tienda online</title>
    <link rel="icon" type="image/png" href="../public/assets/img/logo-tienda.png"/>
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Customized Bootstrap Stylesheet -->
    <link href="../public/assets/css/style.css" rel="stylesheet">
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
        <a href="../index.php" class="text-decoration-none d-inline-flex align-items-center gap-2">
          <img src="../public/assets/img/logo-tienda.png" alt="Mystic Waves" class="img-fluid" style="max-width:200px; height:auto;">
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

      <div class="col-lg-3 text-lg-end">
       <?php include_once __DIR__ . '/../public/partials/cartbar.php'; ?>
      </div>
    </div>
  </div>
</div>

<!-- MAIN CONTENT -->
<main class="flex-grow-1">
  <div class="container-xxl my-5">
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-8">
        <div class="card border-0 shadow-sm">
          <div class="card-body p-5 text-center">
            <div class="mb-4">
              <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 4rem;"></i>
            </div>
            
            <h2 class="mb-3 fw-bold text-danger">¡Oops! Algo salió mal</h2>
            
            <div class="alert alert-danger mb-4" role="alert">
              <i class="bi bi-info-circle-fill me-2"></i>
              <?php echo htmlspecialchars($errorMessage); ?>
            </div>

            <p class="text-muted mb-4">
              No te preocupes, puedes volver a intentarlo o regresar a la página de inicio.
            </p>

            <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
              <a href="javascript:history.back()" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left me-2"></i>Volver atrás
              </a>
              <a href="../index.php" class="btn btn-primary">
                <i class="bi bi-house-fill me-2"></i>Ir al inicio
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<!-- FOOTER -->
    <?php include_once __DIR__ . '/../public/partials/footer.php' ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
