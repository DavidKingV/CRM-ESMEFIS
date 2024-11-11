<?php
require_once __DIR__ . '/../../vendor/autoload.php';

$ClientId = $_POST['ClientId'] ?? null;
$ClientName = $_POST['ClientName'] ?? null;
?>
<form class="py-2" id="addClientComment">
    <div class="form-group">
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Comentarios para el alumno: <strong><?php echo $ClientName; ?> </strong></label>
            <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
        </div>
        <hr class="divider">
        <div class="mb-3">
            <div class="my-2"></div>
            <button type="submit" class="btn btn-success btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-check"></i>
                </span>
                <span class="text">Agregar</span>
            </button>
        </div>
    </div>  
</form>

<script type="module">
import { enviarPeticionAjax} from './js/utils/fetch.js';
import { loadingAlert, errorAlert } from './js/utils/sweetAlert.js';

const phpPath = '../public/api/Customers.php';

$("#addClientComment").on("submit", function(e){
        e.preventDefault();

        let commentData = $(this).serialize();
        commentData += `&clientId=${<?php echo $ClientId; ?>}`;


        loadingAlert();

        enviarPeticionAjax(phpPath, 'POST', { action: 'addComment', commentData })
        .done(function(data) {
            Swal.close();
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Comentario agregado',
                    text: data.message
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#comentsModal').modal('hide');
                        $('#clientsTable').DataTable().ajax.reload();
                        $('#noCommentsClientsTable').DataTable().ajax.reload();
                        $('#historyComments').DataTable().ajax.reload();
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message
                });
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            Swal.close();
            errorAlert("Error en la petición AJAX");
        });
    });
</script>