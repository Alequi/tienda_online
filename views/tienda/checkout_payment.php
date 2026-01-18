<?php

session_start();

require '../../vendor/autoload.php';

require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../config/conexion.php';
$con = conectar();
require_once __DIR__ . '/../../actions/cart/view.php';
require_once __DIR__ . '/../../actions/usuarios_action.php';

// Validar que el carrito tenga items
if (empty($cart_items)) {
    header('Location: cart.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras | Mystic Waves</title>
    <link rel="icon" type="image/png" href="../../public/assets/img/logo-tienda.png" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="../../public/assets/css/style.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">

    <?php include_once __DIR__ . '/../../public/partials/topbar.php'; ?>

    <!-- BRAND + SEARCH + CART -->
    <div class="bg-white">
        <div class="container-xxl py-3">
            <div class="row align-items-center g-3">
                <div class="col-12 col-lg-3 text-center text-lg-start">
                    <a href="../../index.php" class="text-decoration-none d-inline-flex align-items-center gap-2">
                        <img src="../../public/assets/img/logo-tienda.png" alt="Mystic Waves" class="img-fluid" style="max-width:200px; height:auto;">
                    </a>
                </div>

                <div class="col-9 col-lg-6">
                    <form action="#">
                        <div class="input-group">
                            <input type="search" class="form-control" placeholder="Buscar anillos, colgantes, plata 925..." aria-label="Buscar">
                            <button class="btn btn-outline-secondary" type="submit" aria-label="Buscar">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="col-3 col-lg-3 text-end">
                    <?php include_once __DIR__ . '/../../public/partials/cartbar.php'; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <div class="container-xxl my-3">
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
                    <li class="nav-item"><a class="nav-link" href="nosotros.php">Sobre nosotros</a></li>
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
                                    <li><a class="dropdown-item" href="../user/panel.php"><i class="bi bi-person"></i> Perfil Personal</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="../../actions/logout_action.php"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a></li>
                                </ul>
                        </li>
                    </ul>
                <?php else: ?>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="../user/panel.php"><i class="bi bi-person"></i> Panel de usuario</a></li>
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
    </div>
    <!-- FIN Navbar -->
    <div class="container-xxl flex-grow-1 my-4">
        <div class="row g-4">
            <div class="col-12 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0"><i class="bi bi-credit-card-2-back"></i> Metodo de pago - Tarjeta</h5>
                    </div>
                    <div class="card-body">
                        <form id="payment-form">
                            <div class="mb-3">
                                <label for="cardName" class="form-label">Nombre en la tarjeta</label>
                                <input type="text" class="form-control" id="cardName" name="cardName" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Información de la tarjeta</label>
                                <div id="card-element" class="form-control" style="height: auto; padding: 10px;"></div>
                                <div id="card-errors" class="text-danger mt-2"></div>
                            </div>

                            <button type="button" class="btn btn-secondary f-end me-2" onclick="window.location.href='checkout_shipping.php';"><i class="bi bi-arrow-left"></i> Volver</button>
                            <button type="submit" class="btn btn-success btn-lg px-5" id="submit-button">
                                <span id="button-text"><i class="bi bi-check2-square"></i> Pagar Ahora</span>
                                <span id="spinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0"><i class="bi bi-bag-fill"></i> Resumen del pedido</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($cart_items)): ?>
                            <ul class="list-group mb-3">
                                <?php foreach ($cart_items as $item): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="my-0"><?php echo htmlspecialchars($item['nombre']); ?></h6>
                                            <small class="text-muted">Cantidad: <?php echo $item['cantidad']; ?></small>
                                        </div>
                                        <span class="text-muted"><?php echo number_format($item['precio'] * $item['cantidad'], 2); ?> €</span>
                                    </li>
                                <?php endforeach; ?>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Subtotal</span>
                                    <strong><?php echo number_format($total_price, 2); ?> €</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Envío</span>
                                    <strong><?php echo $envio > 0 ?  number_format($envio, 2) . ' €' : 'GRATIS'; ?></strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between bg-light">
                                    <span><strong>Total (EUR)</strong></span>
                                    <strong><?php echo number_format($total_con_envio, 2); ?> €</strong>
                                </li>
                            </ul>
                        <?php else: ?>
                            <p class="text-center">Tu carrito está vacío.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- FOOTER -->


    <?php include_once __DIR__ . '/../../public/partials/footer.php'; ?>

    <script src="https://js.stripe.com/v3/"></script>
    <script src="../../public/assets/lib/stripe/checkout.js"></script>
    
    <script src="../../public/assets/lib/scripts/cart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>