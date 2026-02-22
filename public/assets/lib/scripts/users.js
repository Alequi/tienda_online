document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.editBtn');

    editButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            // Obtener los datos del usuario
            const dni = this.getAttribute('data-dni');
            const nombre = this.getAttribute('data-nombre');
            const apellido = this.getAttribute('data-apellidos');
            const direccion = this.getAttribute('data-direccion');
            const localidad = this.getAttribute('data-localidad');
            const provincia = this.getAttribute('data-provincia');
            const telefono = this.getAttribute('data-telefono');
            const email = this.getAttribute('data-email');
            const rol = this.getAttribute('data-rol');
            const activo = this.getAttribute('data-activo');

            // Cargar los datos en el formulario
            document.getElementById('editDNI').value = dni;
            document.getElementById('editNombreUsuario').value = nombre;    
            document.getElementById('editApellidoUsuario').value = apellido;
            document.getElementById('editDireccionUsuario').value = direccion;
            document.getElementById('editLocalidadUsuario').value = localidad;
            document.getElementById('editProvinciaUsuario').value = provincia;
            document.getElementById('editTelefonoUsuario').value = telefono;
            document.getElementById('editEmailUsuario').value = email;
            document.getElementById('editRolUsuario').value = rol;
            document.getElementById('editActivoUsuario').checked = (activo == 1);
            
            // Obtener el DNI del usuario logueado desde el input hidden
            const dniLogueado = document.getElementById('userLoggedDNI')?.value;
            const rolSelect = document.getElementById('editRolUsuario');
            const activoCheckbox = document.getElementById('editActivoUsuario');
            const rolWarning = document.getElementById('rolWarning');
            const activoWarning = document.getElementById('activoWarning');
            
            // Deshabilitar el cambio de rol y estado si es el mismo usuario y es admin
            if (dniLogueado && dni === dniLogueado && rol === 'admin') {
                rolSelect.disabled = true;
                activoCheckbox.disabled = true;
                if (rolWarning) {
                    rolWarning.style.display = 'block';
                }
                if (activoWarning) {
                    activoWarning.style.display = 'block';
                }
            } else {
                rolSelect.disabled = false;
                activoCheckbox.disabled = false;
                if (rolWarning) {
                    rolWarning.style.display = 'none';
                }
                if (activoWarning) {
                    activoWarning.style.display = 'none';
                }
            }
            
            // Mostrar el formulario de edición
            document.getElementById('datos').style.display = 'block';
            // Hacer scroll suave al formulario
            document.getElementById('datos').scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
        );
    });
});
