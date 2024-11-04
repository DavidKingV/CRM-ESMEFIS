<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../backend/controllers/SessionController.php';

use Vendor\Esmefis\DBConnection;

$inputData = json_decode(file_get_contents('php://input'), true);

$connection = new DBConnection();
$controller = new SessionController($connection);

if (!isset($inputData['action'])) {
    responseJson(['error' => 'Action not specified']);
    exit;
}

switch ($inputData['action']) {
    case 'login':
        responseJson($controller->login($inputData));
        break;
    case 'logout':
        responseJson($controller->logout());
        break;
    default:
        responseJson(['error' => 'Invalid action']);
        break;
}

function responseJson($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
}
