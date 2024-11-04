import { sendFetch, sendFormData } from '../utils/fetch.js';
import { successAlert, errorAlert, infoAlert } from '../utils/sweetAlert.js';
import { validateForm, capitalizeFirstLetter, inputLowerCase } from '../utils/validate.js';

const Path = 'api/Clients.php';

$(function() {
    $("#NewClientForm").submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });
        if($(this).valid()){
            SendNewClient(data);
        }
    });

    $("#UploadExcelForm").submit(function(e) {
        e.preventDefault();
        const fileInput = $("#formFile");
        const file = fileInput.prop('files')[0];
        const allowedExtensions = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'];

        if (file && !allowedExtensions.includes(file.type)) {
            errorAlert('El archivo seleccionado no es un archivo de Excel');
            return;
        }else{
            let formData = new FormData(this);
            formData.append('action', 'uploadExcel'); // Aquí se añade el action
            if (file) formData.append('excelFile', file);
            UploadExcel(formData);
        }
    });

    validateForm("#NewClientForm", 
    {
        name: {
            required: true,
            minlength: 3
        },
        email: {
            required: true,
            email: true
        },
        phone: {
            required: true,
            number: true,
            minlength: 10
        },
        program: {
            required: true,
            valueNotEquals: "0"
        },
        program_type: {
            required: true,
            valueNotEquals: "0"
        },
    },
    {
        name: {
            required: "El nombre es requerido",
            minlength: "El nombre debe tener al menos 3 caracteres"
        },
        email: {
            required: "El correo electrónico es requerido",
            email: "El correo electrónico no es válido"
        },
        phone: {
            required: "El teléfono es requerido",
            number: "El teléfono debe ser numérico",
            minlength: "El teléfono debe tener al menos 10 dígitos"
        },
        program: {
            required: "El programa es requerido",
            valueNotEquals: "Por favor, selecciona una opción"
        },
        program_type: {
            required: "El tipo de programa es requerido",
            valueNotEquals: "Por favor, selecciona una opción"
        },
    });

    $("#name").on("input", function(){
        const inputValue = $(this).val();
        const cursorPosition = $(this).prop('selectionStart');
        
        const capitalizedValue = capitalizeFirstLetter(inputValue);
        $(this).val(capitalizedValue);
        
        $(this).prop('selectionStart', cursorPosition);
        $(this).prop('selectionEnd', cursorPosition);
    });

    $("#email").on("input", function(){
        const inputValue = $(this).val();
        const cursorPosition = $(this).prop('selectionStart');
        
        const lowerCaseValue = inputLowerCase(inputValue);
        $(this).val(lowerCaseValue);
        
        $(this).prop('selectionStart', cursorPosition);
        $(this).prop('selectionEnd', cursorPosition);
    });

});

const SendNewClient = async (data) => {
    const response = await sendFetch(Path, 'POST', { action: 'addClient', ...data });
    const result = await response.json();
    if (result.success){
        successAlert(result.message);
        $("#NewClientForm").trigger("reset");        
    }else{
        errorAlert(result.message);
    }
}

const UploadExcel = async (data) => {
    const response = await sendFormData(Path, 'POST', data);
    const result = await response.json();
    if (result.success){
        successAlert(result.message);
        $("#UploadExcelForm").trigger("reset");        
    }else if(!result.success && result.errors){
        let errors = result.errors;
        let errorMessage = '';

        errors.forEach(error => {
            errorMessage += 'Algunos datos no se guardaron: <br>';
            errorMessage += `Fila ${error.row}: ${error.error}`;
            errorMessage += '<br>';
        });

        infoAlert(errorMessage);
    }
    else{
        errorAlert(result.message);
    }
}