<?php
session_start();
require_once "helpers/auth.php";
require_once "actions/products_action.php";
require_once "actions/categorias_action.php";


?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mystic Waves | Tienda online</title>
  <link rel="icon" type="image/png" href="public/assets/img/logo-tienda.png" />
  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">


  <!-- Customized Bootstrap Stylesheet -->
  <link href="public/assets/css/style.css" rel="stylesheet">

</head>

<body class="d-flex flex-column min-vh-100">

  <!-- TOPBAR -->

  <?php include_once 'public/partials/topbar.php'; ?>

  <!-- BRAND + SEARCH + ICONS -->

  <?php include_once 'public/partials/searchbar.php'; ?>

  <!-- NAVBAR + CATEGORIES + CAROUSEL -->
  <div class="container-xxl my-3">
    <div class="row g-3">

      <!-- CATEGORIES (desktop) -->
      
      <?php include_once 'public/partials/categories_navbar.php'; ?>

      <!-- MAIN (navbar + carousel) -->
      <div class="col-lg-9">

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light rounded-3 px-3">
          <a class="navbar-brand d-lg-none fw-bold" href="#">Mystic Waves</a>

          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#shopNavbar"
            aria-controls="shopNavbar" aria-expanded="false" aria-label="Abrir menú">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="shopNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item"><a class="nav-link active" href="index.php">Inicio</a></li>
              <li class="nav-item"><a class="nav-link" href="#">Tienda</a></li>
              <li class="nav-item"><a class="nav-link" href="#">Colecciones</a></li>
              <li class="nav-item"><a class="nav-link" href="views/tienda/nosotros.php">Sobre nosotros</a></li>
              <li class="nav-item"><a class="nav-link" href="views/tienda/contacto.php">Contacto</a></li>
            </ul>

            <?php if (isLoggedIn()): ?>
              <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle"></i> Hola, <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                  </a>
                  <?php if (isAdmin() || isEditor()): ?>


                     <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="admin/adminPanel.php"><i class="bi bi-person"></i> Panel de Administrador</a></li>
                    <li>
                      <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="actions/logout_action.php"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a></li>
                  </ul>
                </li>
              </ul>
                  <?php else: ?>
                  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="views/user/panel.php"><i class="bi bi-person"></i> Panel de usuario</a></li>
                    <li>
                      <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="actions/logout_action.php"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a></li>
                  </ul>
                </li>
              </ul>
                  <?php endif; ?>
            <?php else: ?>
              <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="views/auth/login.php">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="views/auth/registro.php">Registro</a></li>
              </ul>
            <?php endif; ?>
          </div>
        </nav>

        <!-- Carousel -->
        <div id="shopCarousel" class="carousel slide mt-3" data-bs-ride="carousel">
          <div class="carousel-inner rounded-3 overflow-hidden">
            <div class="carousel-item active">
              <img src="public/assets/img/hero-1.png" class="d-block w-100" alt="Colección" style="height:410px; object-fit:cover;">
              <div class="carousel-caption d-flex h-100 align-items-center justify-content-center">
                <div class="p-3" style="max-width: 720px;">
                  <h6 class="text-uppercase fw-semibold mb-2 text-white">Nueva colección</h6>
                  <h2 class="fw-bold mb-3">Joyas con alma, para cada día</h2>
                  <a href="#" class="btn btn-primary">Comprar ahora</a>

                </div>
              </div>
            </div>

            <div class="carousel-item">
              <img src="public/assets/img/hero-2.png" class="d-block w-100" alt="Anillos" style="height:410px; object-fit:cover;">
              <div class="carousel-caption d-flex h-100 align-items-center justify-content-center">
                <div class="p-3" style="max-width: 720px;">
                  <h6 class="text-uppercase fw-semibold mb-2 text-white">Edicion Limitada</h6>
                  <h2 class="fw-bold mb-3">Anillos elegantes en Plata 925</h2>
                  <a href="#" class="btn btn-primary">Comprar ahora</a>
                </div>
              </div>
            </div>
          </div>

          <button class="carousel-control-prev" type="button" data-bs-target="#shopCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
          </button>

          <button class="carousel-control-next" type="button" data-bs-target="#shopCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
          </button>
        </div>

      </div>
    </div>
  </div>

  <!-- PRODUCTS GRID -->

  <h1 class="text-center mb-2 mt-2"><i class="bi bi-stars  text-primary"></i> Lo último en llegar <i class="bi bi-stars  text-primary"></i></h1>

 <div class="container-xxl mt-3 mb-5">
    <div class="row g-4">
      <?php foreach ($productos_index as $producto): ?>
        <div class="col-6 col-md-4 col-lg-3">
          <div class="card h-100">
            <img src="public/assets/img/<?php echo $producto->imagen; ?>" class="card-img-top" alt="Producto <?php echo $producto->codigo; ?>">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title"> <?php echo $producto->nombre; ?></h5>
              <p class="card-text text-muted mb-4">
                <span class="fw-bold text-primary fs-5"><?php echo number_format($producto->precio, 2); ?>€</span>
                <?php if ($producto->precio_anterior && $producto->precio_anterior > 0): ?>
                  <s class="ms-2"><?php echo number_format($producto->precio_anterior, 2); ?>€</s>
                    <?php endif; ?>
              </p>
              <a href="views/tienda/producto.php?codigo=<?php echo $producto->codigo; ?>" class="btn btn-primary mt-auto">Ver más</a>

            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="col-12 mt-5">
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-light py-3">
            <h5 class="mb-0"><i class="bi bi-question-circle"></i> Preguntas frecuentes</h5>
          </div>
          <div class="card-body p-4">
            <div class="accordion" id="faqAccordion">
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    ¿Cuál es el tiempo de entrega?
                  </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                    El tiempo de entrega estándar es de 3-5 días laborables para España peninsular. Para envíos a Baleares, Canarias, Ceuta y Melilla el plazo es de 5-7 días laborables.
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    ¿Puedo devolver un producto?
                  </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                    Sí, aceptamos devoluciones durante los 14 días siguientes a la recepción del pedido. El producto debe estar en perfectas condiciones y con su embalaje original.
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    ¿Los productos tienen garantía?
                  </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                    Todas nuestras joyas cuentan con una garantía de 2 años contra defectos de fabricación. La garantía no cubre el desgaste natural por uso normal.
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>

  <!-- PRODUCTS GRID -->

  


  <!-- FOOTER -->

  <?php include_once 'public/partials/footer.php'; ?>

  <!-- FOOTER -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>