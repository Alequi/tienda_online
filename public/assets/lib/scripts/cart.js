// Manejo de adición al carrito desde formularios con data-add-to-cart

 
// Actualizar el badge del carrito y mostrar alertas

document.addEventListener('DOMContentLoaded', () => {
    const cartBadge = document.getElementById('cartBadge');

    // Escuchar envíos de formularios para añadir al carrito

    document.addEventListener('submit', async (event) => {
        if (event.target.matches('form[data-add-to-cart]')) {
            event.preventDefault(); 

            // Obtener datos del formulario

            const codigoProducto = event.target.querySelector('input[name="codigo_producto"]').value;
            const cantidad = event.target.querySelector('input[name="cantidad"]').value;

            if (!codigoProducto || cantidad <= 0){
                alert('Cantidad inválida.');
                return;
            } 
            // Enviar solicitud para añadir al carrito
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
            }
        }
    });
});



// Event listeners para controles de cantidad y eliminación en cart.php
document.addEventListener('click', async (event) => {
    const target = event.target.closest('[data-action]');
    if (!target) return;

    const action = target.dataset.action;
    const codigo = target.dataset.codigo;

    if (action === 'decrease') {
        const cantidad = parseInt(target.dataset.cantidad);
        if (cantidad > 1) {
            await updateCartItem(codigo, cantidad - 1);
        }
    } else if (action === 'increase') {
        const cantidad = parseInt(target.dataset.cantidad);
        const stock = parseInt(target.dataset.stock);
        if (cantidad < stock) {
            await updateCartItem(codigo, cantidad + 1);
        } else {
            alert('No hay más stock disponible.');
        }
    } else if (action === 'remove') {
        await removeCartItem(codigo);
    }
});

// Manejo de actualización manual de cantidad

document.addEventListener('change', async (event) => {
    if (event.target.matches('[data-action="manual-update"]')) {
        const codigo = event.target.dataset.codigo;
        const cantidad = parseInt(event.target.value);
        const min = parseInt(event.target.min);
        const max = parseInt(event.target.max);

        if (cantidad < min || cantidad > max || isNaN(cantidad)) {
            alert(`Cantidad debe estar entre ${min} y ${max}.`);
            event.target.value = min;
            return;
        }

        await updateCartItem(codigo, cantidad);
    }
});

// Funciones para actualizar y eliminar ítems del carrito
// Usan fetch para comunicarse con actions/cart/update.php
// y recargar la página al completar.

async function updateCartItem(codigoProducto, nuevaCantidad) {
    if (nuevaCantidad <= 0) {
        alert('Cantidad inválida.');
        return;
    }           
    try {
        const response = await fetch('../../actions/cart/update.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },  
            body: JSON.stringify({
                codigo_producto: codigoProducto,
                cantidad: parseInt(nuevaCantidad),
                action: 'update'
            }), 
        }); 
        const result = await response.json();
        if (response.ok && result.ok) {
            location.reload();
        } else {
            alert(result.message || 'Error al actualizar el carrito.');
        }
    }
    catch (error) {
        console.error('Error:', error);
        alert('Error de red al actualizar el carrito.');
    }   
}

// Función para eliminar un ítem del carrito
async function removeCartItem(codigoProducto) {
    if (!confirm('¿Estás seguro de eliminar este producto?')) {
        return;
    }
    
    try {
        const response = await fetch('../../actions/cart/update.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },  
            body: JSON.stringify({
                codigo_producto: codigoProducto,
                action: 'remove'
            }), 
        });
        const result = await response.json();
        if (response.ok && result.ok) {
            location.reload();
        } else {
            alert(result.message || 'Error al eliminar el producto del carrito.');
        }       
    }
    catch (error) {
        console.error('Error:', error);
        alert('Error de red al eliminar el producto del carrito.');
    }       
}   


