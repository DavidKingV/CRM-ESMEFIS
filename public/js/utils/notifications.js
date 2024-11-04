import { sendFetch } from './fetch.js';

let Path = 'api/Inicio.php';

$(function () {

    $("#alertsDropdown").on("click", function(){

        if($('#notiCount').text() > 0){
            sendFetch(Path, 'POST', { action: 'updateNotifications' })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la petición');
                }
                return response.json();  // Asegúrate de que se está retornando la promesa con la conversión a JSON
            })
            .then(data => {
                if(data[0]['success']){
                    $('#notiCount').text(0);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

    });
    
});