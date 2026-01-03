<!-- Product Detail Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Product Image -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <img src="../../public/assets/img/<?= htmlspecialchars($producto['imagen']) ?>" 
                         class="card-img-top" 
                         alt="<?= htmlspecialchars($producto['nombre']) ?>"
                         style="object-fit: cover; height: 500px;">
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <!-- Product Name -->
                        <h1 class="h2 mb-3"><?= htmlspecialchars($producto['nombre']) ?></h1>
                        
                        <!-- Category -->
                        <p class="text-muted mb-3">
                            <i class="bi bi-tag-fill me-2"></i>
                            <span class="badge bg-secondary"><?= htmlspecialchars($producto['categoria']) ?></span>
                        </p>

                        <!-- Price -->
                        <div class="mb-4">
                            <h3 class="text-primary fw-bold"><?= number_format($producto['precio'], 2) ?>€</h3>
                            <?php if (isset($producto['precio_anterior']) && $producto['precio_anterior'] > $producto['precio']): ?>
                                <span class="text-muted text-decoration-line-through">
                                    <?= number_format($producto['precio_anterior'], 2) ?>€
                                </span>
                                <span class="badge bg-danger ms-2">
                                    -<?= round((($producto['precio_anterior'] - $producto['precio']) / $producto['precio_anterior']) * 100) ?>%
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <h5 class="mb-3">Descripción</h5>
                            <p class="text-muted"><?= nl2br(htmlspecialchars($producto['descripcion'])) ?></p>
                        </div>

                        <!-- Stock Status -->
                        <div class="mb-4">
                            <?php if ($producto['stock'] > 0): ?>
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle-fill me-1"></i>
                                    En stock (<?= $producto['stock'] ?> disponibles)
                                </span>
                            <?php else: ?>
                                <span class="badge bg-danger">
                                    <i class="bi bi-x-circle-fill me-1"></i>
                                    Agotado
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Add to Cart Form -->
                        <?php if ($producto['stock'] > 0): ?>
                        <form action="../../actions/add_to_cart.php" method="POST" class="mb-4">
                            <input type="hidden" name="codigo_producto" value="<?= htmlspecialchars($producto['codigo']) ?>">
                            
                            <!-- Quantity Selector -->
                            <div class="mb-3">
                                <label for="cantidad" class="form-label fw-semibold">Cantidad</label>
                                <div class="input-group" style="max-width: 200px;">
                                    <button class="btn btn-outline-secondary" type="button" id="decreaseQty">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <input type="number" 
                                           class="form-control text-center" 
                                           id="cantidad" 
                                           name="cantidad" 
                                           value="1" 
                                           min="1" 
                                           max="<?= $producto['stock'] ?>"
                                           required>
                                    <button class="btn btn-outline-secondary" type="button" id="increaseQty">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Add to Cart Button -->
                            <button type="submit" class="btn btn-primary w-100 py-2">
                                <i class="bi bi-cart-plus me-2"></i>
                                Añadir al carrito
                            </button>
                        </form>
                        <?php endif; ?>

                        <!-- Product Info -->
                        <div class="border-top pt-3">
                            <ul class="list-unstyled mb-0 small text-muted">
                                <li class="mb-2">
                                    <i class="bi bi-truck me-2"></i>
                                    Envío gratis en pedidos superiores a 50€
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-shield-check me-2"></i>
                                    Garantía de devolución de 30 días
                                </li>
                                <li>
                                    <i class="bi bi-box-seam me-2"></i>
                                    Código: <?= htmlspecialchars($producto['codigo']) ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quantity Controls Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityInput = document.getElementById('cantidad');
    const decreaseBtn = document.getElementById('decreaseQty');
    const increaseBtn = document.getElementById('increaseQty');
    const maxStock = <?= $producto['stock'] ?>;

    decreaseBtn.addEventListener('click', function() {
        const currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
        }
    });

    increaseBtn.addEventListener('click', function() {
        const currentValue = parseInt(quantityInput.value);
        if (currentValue < maxStock) {
            quantityInput.value = currentValue + 1;
        }
    });

    quantityInput.addEventListener('input', function() {
        let value = parseInt(this.value);
        if (isNaN(value) || value < 1) {
            this.value = 1;
        } else if (value > maxStock) {
            this.value = maxStock;
        }
    });
});
</script>
