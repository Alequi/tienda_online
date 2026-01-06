document.addEventListener('DOMContentLoaded', function() {
    const btnVerPedidos = document.getElementById('btnVerPedidos');
    const btnVerDatos = document.getElementById('btnVerDatos');

    btnVerDatos.addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('pedidos').style.display = 'none';
        document.getElementById('datos').style.display = 'block';
    });
    
    btnVerPedidos.addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('datos').style.display = 'none';
        document.getElementById('pedidos').style.display = 'block';
    });
});
