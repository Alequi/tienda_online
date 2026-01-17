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
                            <p class="text-muted mb-4">Gracias por tu compra. Tu pedido ha sido procesado exitosamente.</p>

                            <div class="alert alert-light border mb-4">
                                <p class="mb-1 text-muted small">Número de Pedido</p>
                                <h4 class="mb-0 fw-bold">MW-20260117-2435</h4>
                            </div>

                            <div class="row text-start mb-4">
                                <div class="col-6 mb-3">
                                    <p class="mb-1 text-muted small">Fecha</p>
                                    <p class="mb-0 fw-semibold">17/01/2026</p>
                                </div>
                                <div class="col-6 mb-3">
                                    <p class="mb-1 text-muted small">Estado</p>
                                    <p class="mb-0"><span class="badge bg-success">Confirmado</span></p>
                                </div>
                                <div class="col-12">
                                    <p class="mb-1 text-muted small">Email de Confirmación</p>
                                    <p class="mb-0 fw-semibold">usuario@email.com</p>
                                </div>
                            </div>

                            <div class="alert alert-info mb-4">
                                <i class="bi bi-envelope-check me-2"></i>
                                Recibirás un correo electrónico con los detalles de tu pedido.
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
                                <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                    <img src="../../public/assets/img/producto1.jpg" alt="Producto" class="me-3" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Anillo de Plata 925</h6>
                                        <small class="text-muted">Cantidad: 1</small>
                                    </div>
                                    <div class="text-end">
                                        <p class="mb-0 fw-semibold">€45.00</p>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                    <img src="../../public/assets/img/producto2.jpg" alt="Producto" class="me-3" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Colgante Luna</h6>
                                        <small class="text-muted">Cantidad: 2</small>
                                    </div>
                                    <div class="text-end">
                                        <p class="mb-0 fw-semibold">€60.00</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Totales -->
                            <div class="border-top pt-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Subtotal</span>
                                    <span class="fw-semibold">€105.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Envío</span>
                                    <span class="fw-semibold">€5.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                                    <span class="text-muted">IVA (21%)</span>
                                    <span class="fw-semibold">€22.05</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="h5 mb-0">Total</span>
                                    <span class="h5 mb-0 text-primary">€132.05</span>
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
