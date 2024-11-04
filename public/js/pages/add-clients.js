import { sendFetch } from '../utils/fetch.js';
import { successAlert, errorAlert } from '../utils/sweetAlert.js';
import { validateForm, capitalizeFirstLetter, inputLowerCase } from '../utils/validate.js';

const Path = '/api/Clients.php';

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
    if (response.success){
        successAlert(result.message);
        $("#NewClientForm").trigger("reset");        
    }else{
        errorAlert(result.message);
    }
};