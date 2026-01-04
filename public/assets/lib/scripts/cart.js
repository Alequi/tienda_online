document.addEventListener('DOMContentLoaded', () => {
    const cartBadge = document.getElementById('cartBadge');

    document.addEventListener('submit', async (event) => {
        if (event.target.matches('form[data-add-to-cart]')) {
            event.preventDefault(); 

            const codigoProducto = event.target.querySelector('input[name="codigo_producto"]').value;
            const cantidad = event.target.querySelector('input[name="cantidad"]').value;

            if (!codigoProducto || cantidad <= 0){
                alert('Cantidad inválida.');
                return;
            } 

            try{
                const response = await fetch('../../actions/cart/add.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        codigo_producto: codigoProducto,
                        cantidad: parseInt(cantidad)
                    }),
                });
                const result = await response.json();

                if (response.ok && result.ok){
                    if (cartBadge) {
                        cartBadge.textContent = result.cart_count;
                    }
                    alert(result.message || 'Producto añadido al carrito.');
                } else {
                    alert(result.message || 'Error al añadir al carrito.');
                }

            } catch (error){
                console.error('Error:', error);
                alert('Error de red al añadir al carrito.');
                return;
            }
        }
    });
});
