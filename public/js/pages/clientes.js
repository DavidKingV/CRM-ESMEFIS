import { initializeDataTable } from '../utils/dataTables.js';

var phpPath = 'api/Customers.php';

$(function() {
    initializeDataTable('#customersTable', phpPath, { action: 'getCustomers' }, [ 
        { data: 'id', 'className': 'text-center' },
        { data: 'nombre', 'className': 'text-center' },
        { data: 'telefono', 'className': 'text-center' },
        { data: 'email', 'className': 'text-center' },
        { data: 'licenciatura', 'className': 'text-center' },
        { data: 'programa', 'className': 'text-center', 'defaultContent': 'N/A' },
        { data: null, render: function(data, type, row) { 
            if (row.estatus == 1){  
                return '<span class="badge text-bg-warning">'+row.labelStatus+'</span>';
            }
            else if(row.estatus == 2){
                return '<span class="badge text-bg-info">'+row.labelStatus+'</span>';
            }
            else if(row.estatus == 3){
                return '<span class="badge text-bg-danger">'+row.labelStatus+'</span>';
            }
            else if(row.estatus == 4){
                return '<span class="badge text-bg-success">'+row.labelStatus+'</span>';
            }else{
                return '<span class="badge text-bg-secondary">'+row.labelStatus+'</span>';
            }
        }, 'className': 'text-center' },
        { data: 'id', render: function(data, type, row) { 
            return '<a href="cliente-info.php?id='+data+'" class="btn btn-info btn-sm">Ver</a>';
        }, 'className': 'text-center' }

        
    ]);
});