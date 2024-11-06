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
                    'nombre' => $row['nombre'],
                    'telefono' => $row['telefono'],
                    'email' => $row['email'],
                    'licenciatura' => $row['licenciatura'],
                    'programa' => $row['programa'],
                    'origen' => $row['origen'],
                    'fecha_registro' => $row['creacion'],
                    'estatus' => $row['estatus'],
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
}