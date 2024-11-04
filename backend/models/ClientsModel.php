<?php
require_once __DIR__.'/../../vendor/autoload.php';

use Vendor\Esmefis\DBConnection;

class ClientsModel{
    private $db;

    public function __construct(DBConnection $db) {
        $this->db = $db->getConnection();
    }

    public function addClient($data) {
        $stmt = $this->db->prepare("INSERT INTO potential_clients (name, phone, email, program, program_type, origin) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('sssisi', $data['name'], $data['phone'], $data['email'], $data['program'], $data['program_type'], $data['origin']);

        try {
            $stmt->execute();
            $stmt->close();
            return ['success' => true, 'message' => 'Cliente agregado correctamente'];
        } catch (Exception $e) {
            if ($e->getCode() == 1062) {
                return ['success' => false, 'message' => 'El cliente ya existe'];
            }

            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function addClientFromExcel($row){
        $clientCheck=$this->db->prepare("SELECT COUNT(*) FROM potential_clients WHERE phone = ?");
        $clientCheck->bind_param('s', $row['phone']);
        $clientCheck->execute();
        $clientCheck->bind_result($count);
        $clientCheck->fetch();
        $clientCheck->close();

        if($count>0){
            throw new Exception('El cliente ya existe');
        }

        $stmt = $this->db->prepare("INSERT INTO potential_clients (name, phone, email, program) VALUES (?, ?, ?, ?)");
        
        if($stmt){
            $stmt->bind_param('sssi', $row[1], $row[3], $row[2], $row[6]);
            $stmt->execute();
            $stmt->close();

            return ['success' => true, 'message' => 'Cliente agregado correctamente'];
        }else{
            return ['success' => false, 'message' => 'Error al agregar el cliente'];
        }
    }
}