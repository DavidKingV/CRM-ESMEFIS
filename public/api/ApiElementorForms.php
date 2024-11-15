<?php
include_once __DIR__.'/../../vendor/autoload.php';
include_once __DIR__.'/../../backend/controllers/ApiSenderController.php';
include_once __DIR__.'/../../backend/controllers/EmailSenderController.php';
include_once __DIR__.'/../../backend/controllers/NotificationsController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decodificar el cuerpo de la solicitud
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Verifica que los datos hayan sido decodificados correctamente
    if (!$data) {
        echo json_encode([
            'success' => false,
            'message' => 'No se pudieron decodificar los datos. Verifica que el formulario esté enviando un JSON válido.'
        ]);
        return;
    }

    // Asignar los valores de los datos recibidos
    $name = $data['Nombre'] ?? $data['nombre'] ?? $data['Nombre_Completo'] ?? null;
    $phone = $data['WhatsApp'] ?? $data['telefono'] ?? null;
    $email = $data['Email'] ?? $data['email'] ?? null;
    $program = !empty($data['form_name']) ? $data['form_name'] : ($data['licenciatura'] ?? $data['Licenciatura'] ?? $data['Servicio_de_interés'] ?? $data['Interés'] ?? null);
    $type_program = $data['Programa'] ?? $data['programa'] ?? $data['Tipo_de_programa'] ?? '';
    $origin = $data['Page_URL'] ?? null;

    if ($name && $phone) {
        $verifyProgram = ApiSender::verifyProgram($program);

        if (!$verifyProgram) {
            echo json_encode([
                'success' => false,
                'message' => 'La licenciatura seleccionada no es válida. Se recibió: ' . $program
            ]);
            return;
        } else {
            $program = $verifyProgram['program'];
            $programLabel = $verifyProgram['program_label'];
        }

        if ($origin == null) $origin = 1;

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
        if ($apiResponse['success']) {
            $emailResponse = EmailSender::sendEmail($dataToSend);
            if ($emailResponse['success']) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Datos enviados correctamente'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => $emailResponse['message']
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => $apiResponse['message']
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Faltan campos requeridos. Lo que se recibió: ' . json_encode($data)
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido.'
    ]);
}
