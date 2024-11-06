<?php
include_once __DIR__.'/../../vendor/autoload.php';
include_once __DIR__.'/../../backend/controllers/ApiSenderController.php';
include_once __DIR__.'/../../backend/controllers/EmailSenderController.php';
include_once __DIR__.'/../../backend/controllers/NotificationsController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $data = $_POST;

    $name = $data['Nombre'] ?? $data['nombre'] ?? $data['Nombre_Completo'] ?? null;
    $phone = $data['WhatsApp'] ?? $data['telefono'] ?? null;
    $email = $data['Email'] ?? $data['email'] ?? null;
    $program = !empty($data['form_name']) ? $data['form_name'] : ($data['licenciatura'] ?? $data['Licenciatura'] ?? $data['Servicio_de_interés'] ?? $data['Interés'] ?? null);
    $type_program = $data['Programa'] ?? $data['programa'] ?? $data['Tipo_de_programa'] ?? '';
    $origin = $data['Page_URL'] ?? null;
   
    if ($name && $phone) {

        $verifyProgram = ApiSender::verifyProgram($program);

        if(!$verifyProgram){
            echo json_encode([
                'success' => false,
                'message' => 'La licenciatura seleccionada no es válida. Se recibió: '.$program
            ]);
            return;
        }else{
            $program = $verifyProgram['program'];
            $programLabel = $verifyProgram['program_label'];
        }

        if($origin = null):$origin = 1;endif;

        $dataToSend = [
            "name" => $name,
            "phone" => $phone,
            "email" => $email,
            "program" => $program,
            "programLabel" => $programLabel,
            "type_program" => $type_program,
            "origin" => $origin,
        ];

        $apiResponse = ApiSender::sendDataToApi($dataToSend);
        if($apiResponse['success']){
            $emailResponse = EmailSender::sendEmail($dataToSend);
            if($emailResponse['success']){

                

                echo json_encode([
                    'success' => true,
                    'message' => 'Datos enviados correctamente'
                ]);
            }else{
                echo json_encode([
                    'success' => false,
                    'message' => $emailResponse['message']
                ]);
            }
        }else{
            echo json_encode([
                'success' => false,
                'message' => $apiResponse['message']
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Faltan campos requeridos. Lo que se recibio: '.json_encode($data)
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido.'
    ]);
}
    