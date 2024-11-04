import { sendFetch } from '../utils/fetch.js';
import { loadingAlert, successAlert, errorAlert, confirmCloseSession } from './sweetAlert.js';

var phpPath = "api/Login.php";

$(function() {

$("#closeSession").on("click", function(){

    confirmCloseSession("¿Estás seguro de cerrar sesión?", "Cerrar sesión", "Cancelar", function(){
        loadingAlert();

        sendFetch(phpPath, "POST", { action: "logout" })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la petición');
                }
                return response.json();  // Asegúrate de que se está retornando la promesa con la conversión a JSON
            })
            .then(data => {
                window.location.href = "index.php";
            })
            .catch(error => {
                return { success: false, message: 'Hubo un error con la petición.' }; // Asegúrate de que se devuelve en caso de error
            });
        });

    });

});