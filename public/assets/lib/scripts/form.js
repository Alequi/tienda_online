document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');
    const formAlert = document.getElementById('formAlert');

    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Simulación de envío de formulario
        formAlert.classList.remove('d-none', 'alert-danger');
        formAlert.classList.add('alert-success');
        formAlert.textContent = '¡Mensaje enviado con éxito! Te responderemos lo antes posible.';
        
        // Resetear formulario
        contactForm.reset();
        
        // Ocultar alerta después de 5 segundos
        setTimeout(() => {
            formAlert.classList.add('d-none');
        }, 5000);
    });
});