document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.editBtn');

    editButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            // Obtener los datos del producto
            const codigo = this.getAttribute('data-codigo');
            const nombre = this.getAttribute('data-nombre');
            const descripcion = this.getAttribute('data-descripcion');
            const precio = this.getAttribute('data-precio');
            const precioAnterior = this.getAttribute('data-precio-anterior');
            const stock = this.getAttribute('data-stock');
            const activo = this.getAttribute('data-activo');
            const categoria = this.getAttribute('data-categoria');
            const imagen = this.getAttribute('data-imagen');

            // Cargar los datos en el formulario    
            document.getElementById('editCodigo').value = codigo;
            document.getElementById('editNombre').value = nombre;
            document.getElementById('editDescripcion').value = descripcion;
            document.getElementById('editPrecio').value = precio;
            document.getElementById('editPrecioAnterior').value = precioAnterior;
            document.getElementById('editStock').value = stock;
            document.getElementById('editActivo').checked = (activo == 1);
            document.getElementById('editCategoria').value = categoria;
            
            // Mostrar imagen actual
            const previewContainer = document.getElementById('previewImageContainer');
            const previewImage = document.getElementById('previewImage');
            const imagenActual = document.getElementById('imagenActual');
            
            if (imagen) {
                imagenActual.textContent = 'Imagen actual: ' + imagen;
                previewImage.src = '../public/assets/img/' + imagen;
                previewContainer.style.display = 'block';
            } else {
                imagenActual.textContent = '';
                previewContainer.style.display = 'none';
            }

            // Mostrar el formulario de edición
            document.getElementById('datos').style.display = 'block';
            // Hacer scroll suave al formulario
            document.getElementById('datos').scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });
});


