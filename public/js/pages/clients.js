import { initializeDataTable } from '../utils/dataTables.js';
import { sendFetch, enviarPeticionAjax } from '../utils/fetch.js';
import { loadingAlert } from '../utils/sweetAlert.js';


var phpPath = 'api/Customers.php';

$(function() {

    initializeDataTable('#clientsTable', phpPath, { action: 'getCustomers' }, [ 
        { data: 'id', 'className': 'text-center' },
        { data: 'name', 'className': 'text-center' },
        { data: 'email', 'className': 'text-center' },
        { data: 'phone', 'className': 'text-center' },
        { data: null, render: function(data, type, row) { 
            if (row.status == 1){  
                return '<span class="badge-warning">'+row.labelStatus+'</span>';
            }
            else if(row.status == 2){
                return '<span class="badge-info">'+row.labelStatus+'</span>';
            }
            else if(row.status == 3){
                return '<span class="badge-danger">'+row.labelStatus+'</span>';
            }
            else if(row.status == 4){
                return '<span class="badge-success">'+row.labelStatus+'</span>';
            }else{
                return '<span class="badge-secondary">'+row.labelStatus+'</span>';
            }
        }, 'className': 'text-center' },
        { data: 'id', render: function(data, type, row) { 
            return `<a id="addComents" class="btn btn-info btn-icon-split" href="historial-cliente.php?id=`+row.id+`">
                        <span class="icon text-white-50">
                            <i class="fas fa-eye"></i>
                        </span>
                        <span class="text">Ver registros</span>
                    </a>`;
        }, 'className': 'text-center' },
        { data: 'id', render: function(data, type, row) { 
            return `<div class="btn-group">
                    <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                    </button>
                    <ul class="dropdown-menu">
                        <li><button class="dropdown-item" id="deleteClient">Eliminar</button></li>
                        <li><button class="dropdown-item" id="editClient">Editar</button></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><button class="dropdown-item" id="">Ver historial</button></li>
                    </ul>
                    </div>`;
        }, 'className': 'text-center' }

        
    ]);
    
});