document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.editBtn');

    editButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            // Obtener los datos de la categoría
            const codigo = this.getAttribute('data-codigo');
            const nombre = this.getAttribute('data-nombre');
            const descripcion = this.getAttribute('data-descripcion');
            const activo = this.getAttribute('data-activo');
            const categoriaPadre = this.getAttribute('data-categoriapadre') || '';

            // Cargar los datos en el formulario
            document.getElementById('editCodigo').value = codigo;
            document.getElementById('editNombreCategoria').value = nombre;
            document.getElementById('editDescripcionCategoria').value = descripcion;
            document.getElementById('editActivoCategoria').checked = (activo == 1);
            document.getElementById('editCategoriaPadre').value = categoriaPadre;

            // Mostrar el formulario de edición
            document.getElementById('datos').style.display = 'block';
            
            // Hacer scroll suave al formulario
            document.getElementById('datos').scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });
});

        