<?php

session_start();
require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../actions/cart/view.php';

// Verificar que el usuario esté logeado
if (!isLoggedIn()) {
    header('Location: ../auth/login.php');
    exit();
}

require_once __DIR__ . '/../../actions/pedidos_action.php';

// Verificar que existe un pedido
if (!$pedido || empty($lineas_pedido)) {
    header('Location: cart.php');
    exit();
}

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Confirmado | Mystic Waves</title>
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

    <!-- CONFIRMACIÓN DE PEDIDO -->
    <main class="flex-grow-1 bg-light py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 mb-4">
                    
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center p-5">
                            
                            <div class="mb-4">
                                <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                            </div>

                            <h1 class="h2 mb-3">¡Pedido Confirmado!</h1>
                            <p class="text-muted mb-4">Gracias por tu compra <?php echo htmlspecialchars($_SESSION['user_name']); ?>. Tu pedido ha sido procesado exitosamente.</p>

                            <div class="alert alert-light border mb-4">
                                <p class="mb-1 text-muted small">Número de Pedido</p>
                                <h4 class="mb-0 fw-bold"><?php echo htmlspecialchars($ultimo_pedido_id); ?></h4>
                            </div>

                            <div class="row text-start mb-4">
                                <div class="col-6 mb-3">
                                    <p class="mb-1 text-muted small">Fecha</p>
                                    <p class="mb-0 fw-semibold"><?php echo $pedido ? date('d/m/Y', strtotime($pedido['fecha'])) : date('d/m/Y'); ?></p>
                                </div>
                                <div class="col-6 mb-3">
                                    <p class="mb-1 text-muted small">Estado</p>
                                    <p class="mb-0"><span class="badge bg-success"><?php echo $pedido ? ucfirst($pedido['estado']) : 'Confirmado'; ?></span></p>
                                </div>
                        
                            </div>

                            <a href="../../index.php" class="btn btn-primary btn-lg px-5">
                                <i class="bi bi-shop me-2"></i>Seguir Comprando
                            </a>

                        </div>
                    </div>

                </div>

                <!-- RESUMEN DEL PEDIDO -->
                <div class="col-lg-5">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>Resumen del Pedido</h5>
                        </div>
                        <div class="card-body">
                            
                            <!-- Productos -->
                            <div class="mb-3">
                                <?php foreach ($lineas_pedido as $linea): ?>
                                <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                    <img src="../../public/assets/img/<?php echo htmlspecialchars($linea['imagen_articulo']); ?>" alt="Producto" class="me-3" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1"><?php echo htmlspecialchars($linea['nombre_articulo']); ?></h6>
                                        <small class="text-muted">Cantidad: <?php echo htmlspecialchars($linea['cantidad']); ?></small>
                                    </div>
                                    <div class="text-end">
                                        <p class="mb-0 fw-semibold"><?php echo number_format($linea['precio'] * $linea['cantidad'], 2); ?> </p>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted"><i class="bi bi-truck"></i> Envío</span>
                                    <span class="fw-semibold"> <?php if ($envio == 0.0) echo 'Gratis'; else echo number_format($envio, 2) . '€'; ?> </span>
                                </div>
                            </div>

                            <!-- Totales -->
                            <div class="border-top pt-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Subtotal</span>
                                    <span class="fw-semibold"><?php echo number_format($subtotal_sin_iva, 2); ?> €</span>
                                </div>
                                 
                                <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                                    <span class="text-muted">IVA (21%)</span>
                                    <span class="fw-semibold"><?php echo number_format($iva, 2); ?> €</span>
                                </div>
                               
                                <div class="d-flex justify-content-between">
                                    <span class="h5 mb-0">Total</span>
                                    <span class="h5 mb-0 text-primary"><?php echo number_format($total_iva, 2); ?> €</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <?php include_once __DIR__ . '/../../public/partials/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
