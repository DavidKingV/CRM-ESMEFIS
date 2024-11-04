<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../backend/controllers/ClientsController.php';

use Vendor\Esmefis\DBConnection;

$inputData = json_decode(file_get_contents('php://input'), true);

$connection = new DBConnection();
$controller = new ClientsController($connection);

if ($inputData === null) {
    // Si no se detecta JSON, usa $_POST para acceder a los datos
    $inputData = $_POST;
}

if (!isset($inputData['action'])) {
    responseJson(['error' => 'Action not specified']);
    exit;
}

switch ($inputData['action']) {
    case 'addClient':
        responseJson($controller->addClient($inputData));
        break;

    case 'uploadExcel':
        responseJson($controller->uploadClientsExcel());
        break;
    default:
        responseJson(['error' => 'Invalid action']);
        break;
}

function responseJson($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
}
