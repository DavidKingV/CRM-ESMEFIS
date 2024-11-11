import { initializeDataTable } from '../utils/dataTables.js';
import { enviarPeticionAjax } from '../utils/fetch.js';
import { validateForm } from '../utils/validate.js';
import { successAlert, errorAlert, loadingAlert } from '../utils/sweetAlert.js';

var phpPath = 'api/Customers.php';

$(function() {

    initializeDataTable('#clientsTable', phpPath, { action: 'getCustomerComments' }, [ 
        { data: 'clientId', 'className': 'text-center' },
        { data: 'clientName', 'className': 'text-center' },
        { data: 'comment', 'className': 'text-center' },
        { data: 'last_modify', 'className': 'text-center' },
        { data: null, render: function(data, type, row) { 
            if (row.clientStatus == 1){  
                return '<span class="badge-warning clientStatus" data-id="'+row.clientId+'">PENDIENTE</span>';
            }
            else if(row.clientStatus == 2){
                return '<span class="badge-info clientStatus" data-id="'+row.clientId+'">INSCRITO</span>';
            }
            else if(row.clientStatus == 3){
                return '<span class="badge-danger clientStatus" data-id="'+row.clientId+'">SEGUIMIENTO</span>';
            }
            else if(row.clientStatus == 4){
                return '<span class="badge-success clientStatus" data-id="'+row.clientId+'">DESCARTADO</span>';
            }else{
                return '<span class="badge-secondary clientStatus" data-id="'+row.clientId+'">DESCONOCIDO</span>';
            }
        }, 'className': 'text-center' },
        { data: 'id', render: function(data, type, row) { 
            return `<button id="addComents" class="btn btn-success btn-icon-split" data-bs-toggle="modal" data-bs-target="#comentsModal" data-id="`+row.clientId+`" data-name="`+row.clientName+`">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Agregar nuevo comentario</span>
                    </button>`;
        }, 'className': 'text-center' },
        { data: 'id', render: function(data, type, row) { 
            return `<a id="addComents" class="btn btn-info btn-icon-split" href="historial-cliente.php?client=`+row.clientId+`">
                        <span class="icon text-white-50">
                            <i class="fas fa-history"></i>
                        </span>
                        <span class="text">Ver historial</span>
                    </a>`;
        }, 'className': 'text-center' }

        
    ]);

    initializeDataTable('#noCommentsClientsTable', phpPath, { action: 'noCommentsClientsTable' }, [ 
        { data: 'id', 'className': 'text-center' },
        { data: 'name', 'className': 'text-center' },
        { data: 'phone', 'className': 'text-center' },
        { data: 'program', 'className': 'text-center' },
        { data: 'program_type', 'className': 'text-center' },
        { data: 'id', render: function(data, type, row) { 
            return `<button id="addNewComment" class="btn btn-success btn-icon-split" data-bs-toggle="modal" data-bs-target="#comentsModal" data-id="`+row.id+`" data-name="`+row.name+`">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Agregar</span>
                    </button>`;
        }, 'className': 'text-center' },

        
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

    $('#clientsTable').on('click', '.clientStatus', function(e){
        e.preventDefault();
        let clientId = $(this).data('id');
        $('#statusForm input[name="clientId"]').val(clientId);
        $('#statusModal').modal('show');
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