import { enviarPeticionFormData } from '../utils/fetch.js';
import { loadingAlert, successAlert, errorAlert } from '../utils/sweetAlert.js';

var phpPath = "api/envio.php";

$(function() {
    $("#submitEmails").on("click", function(event) {
        event.preventDefault();

        const form = document.getElementById('sendEmails');
        const formData = new FormData(form);
        loadingAlert();

        enviarPeticionFormData(phpPath, "POST", formData )
        .then(response => {
            console.log(formData);
            if (!response.ok) {
                throw new Error('Error en la petición');
            }
            return response.json();  // Asegúrate de que se está retornando la promesa con la conversión a JSON
        })
        .then(data => {
            // Aquí verificas y retornas un objeto que contenga los valores esperados
            if (data.success) {
                console.log('Envio exitoso:', data.message);
                successAlert(data.message);
                setTimeout(() => {
                    window.location.href = "inicio.php";
                }, 1500);
            } else {
                console.error('Error:', data.message);
                errorAlert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error.message);
            errorAlert('Hubo un error con la petición.');
            return { success: false, message: 'Hubo un error con la petición.' }; // Asegúrate de que se devuelve en caso de error
        });
    });
});