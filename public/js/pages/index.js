import { sendFetch } from '../utils/fetch.js';
import { loadingAlert, successAlertLogin, errorAlert } from '../utils/sweetAlert.js';

var path = "/api/Login.php";

$(function() {

    $('[data-bs-toggle="tooltip"]').tooltip();

    $("#loginForm").on("submit", function(event) {
        event.preventDefault();

        let formData = $(this).serializeArray(); // Serializar el formulario en un array de objetos
        let loginData = {};
    
        // Convertir el array de objetos en un objeto clave-valor
        formData.forEach(field => {
            loginData[field.name] = field.value;
        });

        loadingAlert();

        sendFetch(path, "POST", { action: "login", ...loginData })
        .then(response => {
            if (!response.ok) {
                throw new Error('Ocurrió un error al realizar la petición: ' + response.statusText);
            }
            return response.json();  // Asegúrate de que se está retornando la promesa con la conversión a JSON
        })
        .then(data => {
            // Aquí verificas y retornas un objeto que contenga los valores esperados
            if (data.success) {
                successAlertLogin(data.message);
                setTimeout(() => {
                    window.location.href = "inicio.php";
                }, 1500);
            } else {
                errorAlert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            return { success: false, message: error}; // Asegúrate de que se devuelve en caso de error
        });
    });


});