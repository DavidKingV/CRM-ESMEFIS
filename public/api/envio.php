<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../backend/controllers/EmailController.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['file']) && isset($_POST['template'])) {
        $controller = new EmailController();
        $response = $controller->processExcelUpload($_FILES, $_POST['template']);

        // Devolver una respuesta en formato JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // Manejar el error si no se han enviado correctamente los datos
        echo json_encode([
            'status' => 'error',
            'message' => 'Archivo o plantilla no enviado correctamente.'
        ]);
    }
}
?>
