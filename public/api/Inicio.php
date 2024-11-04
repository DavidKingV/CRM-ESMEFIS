<?php
require_once __DIR__.'/../../vendor/autoload.php';
require_once __DIR__.'/../../backend/controllers/NotificationsController.php';

use Vendor\Esmefis\DBConnection;

$inputData = json_decode(file_get_contents('php://input'), true);

$connection = new DBConnection();
$notifications = new NotificationsController($connection);

if (!isset($inputData['action'])) {
    responseJson(['error' => 'Action not specified']);
    exit;
}else{
    switch ($inputData['action']) {
        case 'updateNotifications':
            responseJson($notifications->updateNotifications());
            break;
        default:
            responseJson(['error' => 'Invalid action']);
            break;
    }
}

function responseJson($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
}