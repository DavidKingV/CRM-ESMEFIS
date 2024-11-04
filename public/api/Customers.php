<?php
include_once __DIR__ . "/../../vendor/autoload.php";
include_once __DIR__ . "/../../backend/controllers/CustomerDataController.php";

use Vendor\Esmefis\DBConnection;

$connection = new DBConnection();
$customerDataController = new CustomerDataController($connection);

$action = $_POST['action'] ?? null;

if($action){
    switch ($action) {
        case 'getCustomers':
            $listarClientes = $customerDataController->getCustomersData();
            header('Content-Type: application/json');
            echo json_encode($listarClientes);
            break;
        
        default:
            # code...
            break;
    }
}else{
    return json_encode(['error' => 'No se ha especificado una acción']);
}