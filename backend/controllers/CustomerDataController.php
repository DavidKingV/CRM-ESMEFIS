<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__.'/../models/CustomerDataModel.php';

use Vendor\Esmefis\DBConnection;

class CustomerDataController{
    private $db;
    private $customerData;

    public function __construct(DBConnection $db) {
        $this->db = $db->getConnection();
        $this->customerData = new CustomerData($db);
    }

    public function getTotalClientes() {
        return $this->customerData->getTotalClientes();
    }

    public function programsCount() {
        return $this->customerData->programsCount();
    }

    public function originsCount() {
        return $this->customerData->originsCount();
    }

    public function getCustomersData() {
        $connection = new DBConnection();

        $customerData = new CustomerData($connection);
        $result = $customerData->getCustomersData();

        $data = array();
        if($result !== NULL){
            while ($row = $result->fetch_assoc()) {
                $data[] = array(
                    'success' => true,
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'phone' => $row['phone'],
                    'email' => $row['email'],
                    'program' => $row['program'],
                    'programLabel' => $row['programs'],
                    'program_type' => $row['program_type'],
                    'origin' => $row['origin'],
                    'create_date' => $row['create_date'],
                    'status' => $row['status'],
                    'labelStatus' => $row['labelStatus']
                );
            }
        } else {
            $data[] = array(
                'success' => false,
                'message' => 'No se encontraron clientes'
            );
        }
        return $data;
    }

    public function getCustomerInfo($customerId){
        $connection = new DBConnection();

        $customerData = new CustomerData($connection);
        $result = $customerData->getCustomerInfo($customerId);

        $data = array();
        if($result !== NULL){
            while ($row = $result->fetch_assoc()) {
                $data = array(
                    'success' => true,
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'phone' => $row['phone'],
                    'email' => $row['email'],
                    'program' => $row['program'],
                    'programLabel' => $row['programLabel'],
                    'program_type' => $row['program_type'],
                    'origin' => $row['origin'],
                    'create_date' => $row['create_date'],
                    'status' => $row['status'],
                    'labelStatus' => $row['labelStatus']
                );
            }
        } else {
            $data = array(
                'success' => false,
                'message' => 'No se encontraron clientes'
            );
        }
        return $data;
    }

    public function addCustomerComment($commentDataArray){
        $connection = new DBConnection();

        $customerData = new CustomerData($connection);
        $result = $customerData->addCustomerComment($commentDataArray);

        $data = array();
        if($result !== NULL){
            $data = array(
                'success' => true,
                'message' => 'Comentario agregado'
            );
        } else {
            $data = array(
                'success' => false,
                'message' => 'No se pudo agregar el comentario'
            );
        }
        return $data;
    }

    public function getCustomerComments(){
        $connection = new DBConnection();

        $customerData = new CustomerData($connection);
        $result = $customerData->getCustomerComments();

        $data = array();
        if($result !== NULL){
            while ($row = $result->fetch_assoc()) {
                $data[] = array(
                    'success' => true,
                    'id' => $row['id'],
                    'clientName' => $row['clientName'],
                    'clientId' => $row['client'],
                    'clientStatus' => $row['clientStatus'],
                    'comment' => $row['comment'],
                    'last_modify' => $row['last_modify']
                );
            }
        } else {
            $data[] = array(
                'success' => false,
                'message' => 'No se encontraron comentarios'
            );
        }
        return $data;
    }

    public function noCommentsClientsTable(){
        $connection = new DBConnection();

        $customerData = new CustomerData($connection);
        $result = $customerData->noCommentsClientsTable();

        $data = array();
        if($result !== NULL){
            while ($row = $result->fetch_assoc()) {
                $data[] = array(
                    'success' => true,
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'phone' => $row['phone'],
                    'program' => $row['program_name'],
                    'program_type' => $row['program_type'],
                );
            }
        } else {
            $data[] = array(
                'success' => false,
                'message' => 'No se encontraron clientes sin comentarios'
            );
        }
        return $data;
    }

    public function updateClientStatus($formData){
        $connection = new DBConnection();

        $customerData = new CustomerData($connection);
        $result = $customerData->updateClientStatus($formData);

        $data = array();
        if($result !== NULL){
            $data = array(
                'success' => true,
                'message' => 'Estatus actualizado'
            );
        } else {
            $data = array(
                'success' => false,
                'message' => 'No se pudo actualizar el estatus'
            );
        }
        return $data;
    }

    public function historyComments($clientId){
        $connection = new DBConnection();

        $customerData = new CustomerData($connection);
        $result = $customerData->historyComments($clientId);

        $data = array();
        if($result !== NULL){
            while ($row = $result->fetch_assoc()) {
                $data[] = array(
                    'success' => true,
                    'id' => $row['id'], 
                    'client' => $row['client'],
                    'clientName' => $row['clientName'],
                    'comment' => $row['comment'],
                    'last_modify' => $row['last_modify'],
                    'clientStatus' => $row['clientStatus'],
                );
            }
        } else {
            $data[] = array(
                'success' => false,
                'message' => 'No se encontraron comentarios'
            );
        }
        return $data;
    }

    public function deleteComment($commentId){
        $connection = new DBConnection();

        $customerData = new CustomerData($connection);
        $result = $customerData->deleteComment($commentId);

        $data = array();
        if($result !== NULL){
            $data = array(
                'success' => true,
                'message' => 'Comentario eliminado'
            );
        } else {
            $data = array(
                'success' => false,
                'message' => 'No se pudo eliminar el comentario'
            );
        }
        return $data;
    }
}