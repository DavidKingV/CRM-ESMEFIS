<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Vendor\Esmefis\DBConnection;

class CustomerData
{
    private $db;

    public function __construct(DBConnection $db) {
        $this->db = $db->getConnection();
    }

    public function getTotalClientes() {
        try{
            $stmt = $this->db->prepare("SELECT COUNT(*) AS total FROM potential_clients");
            $stmt->execute();
            $stmt->bind_result($total);
            $stmt->fetch();
            $stmt->close();
            return $total;
        } catch (Exception $e) {
            return ['error' => "Error al obtener el total de clientes"];
        }
    }

    public function getTotalVentas() {
        $stmt = $this->db->prepare("SELECT SUM(monto) AS total FROM ventas");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['total'];
    }

    public function programsCount() {
        $stmt = $this->db->prepare("SELECT programs.name AS program_name, COUNT(potential_clients.program) AS count FROM potential_clients JOIN programs ON potential_clients.program = programs.id GROUP BY programs.name;");
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all();

        $programName = [];
        $programCount = [];

        foreach ($data as $row) {
            $programName[] = $row[0]; // Primer campo: nombre de la licenciatura
            $programCount[] = $row[1]; // Segundo campo: cantidad
        }

        // Retornamos los dos arreglos como un array asociativo o por separado según prefieras
        return [$programName, $programCount];
    }

    public function originsCount(){
        $stmt = $this->db->prepare("SELECT clients_origin.name, COUNT(potential_clients.origin) AS cantidad FROM potential_clients JOIN clients_origin ON potential_clients.origin = clients_origin.id GROUP BY clients_origin.name;");
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all();

        $originName = [];
        $originCount = [];

        foreach ($data as $row) {
            $originName[] = $row[0]; // Primer campo: nombre del origen
            $originCount[] = $row[1]; // Segundo campo: cantidad
        }

        // Retornamos los dos arreglos como un array asociativo o por separado según prefieras
        return [$originName, $originCount];
    }

    public function getCustomersData(){
        $stmt = $this->db->prepare("SELECT clientes_potenciales.*, licenciaturas.nombre AS licenciatura, estatus_cliente.estatus AS labelStatus FROM clientes_potenciales JOIN licenciaturas ON clientes_potenciales.licenciatura = licenciaturas.id JOIN estatus_cliente ON clientes_potenciales.estatus = estatus_cliente.id");
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows === 0){
            return null;
        }

        $stmt->close();
        return $result;
    }

    public function getCustomerInfo($customerId){
        $stmt = $this->db->prepare("SELECT clientes_potenciales.*, estatus_cliente.estatus AS labelStatus FROM clientes_potenciales JOIN estatus_cliente ON clientes_potenciales.estatus = estatus_cliente.id WHERE clientes_potenciales.id = ?");
        $stmt->bind_param('i', $customerId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows === 0){
            return null;
        }

        $stmt->close();
        return $result;
    }

}
