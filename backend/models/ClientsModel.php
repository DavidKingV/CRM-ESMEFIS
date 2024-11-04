<?php
require_once __DIR__.'/../../vendor/autoload.php';

use Vendor\Esmefis\DBConnection;

class ClientsModel{
    private $db;

    public function __construct(DBConnection $db) {
        $this->db = $db->getConnection();
    }

    public function addClient($data) {
        $stmt = $this->db->prepare("INSERT INTO potential_clients (name, phone, email, program, program_type) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('sssss', $data['name'], $data['email'], $data['phone'], $data['program'], $data['program_type']);
        $stmt->execute();
        $stmt->close();
        return ['success' => true, 'message' => 'Cliente agregado correctamente'];
    }
}