import { initializeDataTable } from '../utils/dataTables.js';
import { enviarPeticionAjax } from '../utils/fetch.js';
import { validateForm } from '../utils/validate.js';
import { successAlert, errorAlert, loadingAlert, confirmAlert } from '../utils/sweetAlert.js';
import { getCookie } from '../utils/getCookie.js';

var phpPath = 'api/Customers.php';

$(function() {
    initializeDataTable('#historyComments', phpPath, { action: 'historyComments', clientId: getCookie('clientId')}, [ 
        { data: 'id', 'className': 'text-center' },
        { data: 'comment', 'className': 'text-center' },
        { data: 'last_modify', 'className': 'text-center' },        
        { data: 'id', render: function(data, type, row) { 
            return `<button id="deleteComment" class="btn btn-danger btn-icon-split"  data-id="`+row.id+`">
                        <span class="icon text-white-50">
                            <i class="fas fa-trash-alt"></i>
                        </span>
                        <span class="text">Eliminar comentario</span>
                    </button>`;
        }, 'className': 'text-center' }

        
    ]);

    $('#comentsModal').on('show.bs.modal', function (event) {
        // Obtener el botón que activó el modal y el valor de data-id
        let button = $(event.relatedTarget);
        let ClientId = button.data('id');
        let ClientName = button.data('name');
        // Carga el contenido de views/modal.php
        $.post('../backend/views/CommentsModal.php', { ClientId: ClientId, ClientName: ClientName }, function (data) {
            // Insertar el contenido recibido en el modal
            $('#comentsModalBody').html(data);
        });
    });

    $('#historyComments').on('click', '#deleteComment', function(e){
        e.preventDefault();
        let commentId = $(this).data('id');
        
        confirmAlert('¿Estás seguro de eliminar este comentario?', 'Sí, eliminar', 'Cancelar', function() {
            loadingAlert();
            enviarPeticionAjax(phpPath, 'POST', { action: 'deleteComment', commentId: commentId })
            .done(function(data) {
                Swal.close();
                if (data.success) {
                    successAlert(data.message);
                    $('#historyComments').DataTable().ajax.reload();
                } else {
                    errorAlert(data.message);
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                Swal.close();
                errorAlert("Error en la petición AJAX");
            });
        });
        
    });
    
});

validateForm('#statusForm', {
    Clientstatus: {
        required: true,
        valueNotEquals: "0"
    },
},
{
    Clientstatus: {
        required: 'Este campo es obligatorio',
        valueNotEquals: 'Selecciona una opción'
    },
});

$("#statusForm").submit(function(e) {
    e.preventDefault();

    let formData = $(this).serialize();

    loadingAlert();
    
    enviarPeticionAjax(phpPath, 'POST', { action: 'updateClientStatus', formData })
    .done(function(data) {
        Swal.close();
        if (data.success) {
            successAlert(data.message);
            $('#statusModal').modal('hide');
            $("#statusForm").trigger("reset");
            $('#clientsTable').DataTable().ajax.reload();
        } else {
            errorAlert(data.message);
        }
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
        Swal.close();
        errorAlert("Error en la petición AJAX");
    });
});