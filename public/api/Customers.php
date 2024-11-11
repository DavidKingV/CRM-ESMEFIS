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

        case 'addComment':
            $commentData = $_POST['commentData'] ?? null;
            
            parse_str($commentData, $commentDataArray);

            $addComment = $customerDataController->addCustomerComment($commentDataArray);
            header('Content-Type: application/json');
            echo json_encode($addComment);
            break;

        case 'getCustomerComments':
            $getCustomerComments = $customerDataController->getCustomerComments();
            header('Content-Type: application/json');
            echo json_encode($getCustomerComments);
            break;

        case 'historyComments':
            $clientId = $_POST['clientId'] ?? null;
            $historyComments = $customerDataController->historyComments($clientId);
            header('Content-Type: application/json');
            echo json_encode($historyComments);
            break;
        
        case 'noCommentsClientsTable':
            $noCommentsClientsTable = $customerDataController->noCommentsClientsTable();
            header('Content-Type: application/json');
            echo json_encode($noCommentsClientsTable);
            break;


        case 'updateClientStatus':
            $formData = $_POST['formData'] ?? null;

            $updateClientStatus = $customerDataController->updateClientStatus($formData);
            header('Content-Type: application/json');
            echo json_encode($updateClientStatus);
            break;

            case 'deleteComment':
                $commentId = $_POST['commentId'] ?? null;
                $deleteComment = $customerDataController->deleteComment($commentId);
                header('Content-Type: application/json');
                echo json_encode($deleteComment);
                break;

        default:
            # code...
            break;
    }
}else{
    return json_encode(['error' => 'No se ha especificado una acción']);
}