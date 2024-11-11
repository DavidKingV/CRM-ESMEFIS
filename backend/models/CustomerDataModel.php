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
        $stmt = $this->db->prepare("SELECT potential_clients.*, programs.name AS programs, clients_status.description AS labelStatus FROM potential_clients JOIN programs ON potential_clients.program = programs.id JOIN clients_status ON potential_clients.status = clients_status.id");
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows === 0){
            return null;
        }

        $stmt->close();
        return $result;
    }

    public function getCustomerInfo($customerId){
        $stmt = $this->db->prepare("SELECT potential_clients.*, clients_status.description AS labelStatus, programs.name AS programLabel FROM potential_clients JOIN clients_status ON potential_clients.status = clients_status.id JOIN programs ON potential_clients.program = programs.id WHERE potential_clients.id = ?");
        $stmt->bind_param('i', $customerId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows === 0){
            return null;
        }

        $stmt->close();
        return $result;
    }

    public function addCustomerComment($commentDataArray){
        $clientId = $commentDataArray['clientId'];
        $comment = $commentDataArray['comment'];

        $stmt = $this->db->prepare("INSERT INTO clients_comments (client, comment) VALUES (?, ?)");
        $stmt->bind_param('is', $clientId, $comment);
        $stmt->execute();
        $stmt->close();
        return $clientId;
    }

    public function getCustomerComments(){
        $stmt = $this->db->prepare("SELECT * FROM ( SELECT clients_comments.*, potential_clients.name AS clientName, potential_clients.status AS clientStatus, ROW_NUMBER() OVER (PARTITION BY clients_comments.client ORDER BY clients_comments.last_modify DESC) AS rn FROM clients_comments JOIN potential_clients ON clients_comments.client = potential_clients.id ) AS latest_comments WHERE rn = 1;");
        
        if(!$stmt) {
            // Handle prepare statement error
            return null;
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result && $result->num_rows === 0) {
            $stmt->close();
            return null;
        }
    
        $stmt->close();
        return $result;
    }

    public function noCommentsClientsTable(){
        $stmt = $this->db->prepare("SELECT potential_clients.id, potential_clients.name, potential_clients.phone, potential_clients.program_type, programs.name AS program_name FROM potential_clients LEFT JOIN clients_comments ON potential_clients.id = clients_comments.client LEFT JOIN programs ON potential_clients.program = programs.id WHERE clients_comments.comment IS NULL;");
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows === 0){
            return null;
        }

        $stmt->close();
        return $result;
    }

    public function updateClientStatus($formData){
        parse_str($formData, $formDataArray);

        $stmt = $this->db->prepare("UPDATE potential_clients SET status = ? WHERE id = ?");
        $stmt->bind_param('ii', $formDataArray['clientstatus'], $formDataArray['clientId']);
        $stmt->execute();
        
        if($stmt->affected_rows === 0){
            return ['success' => false, 'message' => 'No se realizó ningún cambio'];
        }else{
            return ['success' => true, 'message' => 'Estatus actualizado'];
        }
    }

    public function historyComments($clientId){
        $stmt = $this->db->prepare("SELECT clients_comments.*, potential_clients.name AS clientName, potential_clients.status AS clientStatus FROM clients_comments JOIN potential_clients ON clients_comments.client = potential_clients.id WHERE clients_comments.client = ? ORDER BY clients_comments.last_modify DESC");
        $stmt->bind_param('i', $clientId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows === 0){
            return null;
        }

        $stmt->close();
        return $result;
    }

    public function deleteComment($commentId){
        $stmt = $this->db->prepare("DELETE FROM clients_comments WHERE id = ?");
        $stmt->bind_param('i', $commentId);
        $stmt->execute();
        
        if($stmt->affected_rows === 0){
            return ['success' => false, 'message' => 'No se eliminó ningún comentario'];
        }else{
            return ['success' => true, 'message' => 'Comentario eliminado'];
        }
    }

}
