const stripe = Stripe('pk_test_51Spu8gPfmsSFGJXZl6ztRULDqz26uR2RCiEijaDkDapYuzbyTNm8kYJH3NMFrVrd001s5WYklxGE94hCkc9qMZgk00ADNYXJ87');
const elements = stripe.elements();
const cardElement = elements.create('card', {
    style: {
        base: {
            fontSize: '16px',
            color: '#32325d',
            '::placeholder': {
                color: '#aab7c4'
            }
        }
    }
});
cardElement.mount('#card-element');

cardElement.on('change', ({error}) => {
    const displayError = document.getElementById('card-errors');
    displayError.textContent = error ? error.message : '';
});

const form = document.getElementById('payment-form');
const submitButton = document.getElementById('submit-button');
const buttonText = document.getElementById('button-text');
const spinner = document.getElementById('spinner');

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    submitButton.disabled = true;
    buttonText.classList.add('d-none');
    spinner.classList.remove('d-none');

    const cardName = document.getElementById('cardName').value;

    const {paymentMethod, error} = await stripe.createPaymentMethod({
        type: 'card',
        card: cardElement,
        billing_details: {
            name: cardName
        }
    });

    if (error) {
        document.getElementById('card-errors').textContent = error.message;
        submitButton.disabled = false;
        buttonText.classList.remove('d-none');
        spinner.classList.add('d-none');
    } else {
        try {
            const response = await fetch('../../actions/checkout/checkout_payment_action.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({
                    payment_method_id: paymentMethod.id,
                    card_name: cardName
                })
            });

            // Debug: ver qué responde el servidor
            const text = await response.text();
            console.log('Server response:', text);
            
            let result;
            try {
                result = JSON.parse(text);
            } catch (e) {
                console.error('Error parsing JSON:', e);
                console.error('Response was:', text);
                throw new Error('Respuesta inválida del servidor');
            }

            if (result.success) {
                window.location.href = 'checkout_success.php';
            } else {
                document.getElementById('card-errors').textContent = result.error || 'Error al procesar el pago';
                submitButton.disabled = false;
                buttonText.classList.remove('d-none');
                spinner.classList.add('d-none');
            }
        } catch (error) {
            console.error('Error:', error);
            document.getElementById('card-errors').textContent = 'Error de conexión: ' + error.message;
            submitButton.disabled = false;
            buttonText.classList.remove('d-none');
            spinner.classList.add('d-none');
        }
    }
});

