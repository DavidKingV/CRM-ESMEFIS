<?php
include_once __DIR__.'/../../vendor/autoload.php';

use Vendor\Esmefis\DBConnection;

class NotificationsModel{
    private $db;

    public function __construct(DBConnection $db) {
        $this->db = $db->getConnection();
    }

    public function getNotifications() {
        $query = "SELECT * FROM notifications WHERE seen = 0 ORDER BY date DESC LIMIT 3";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $total = $result->num_rows;
        
        $data = [];

        if($total > 0){
            while ($row = $result->fetch_assoc()) {
                $data[] = [
                    'success' => true,
                    'id' => $row['id'],
                    'title' => $row['title'],
                    'date' => $row['date'],
                    'total' => $total
                ];
            }
        } else if($total === 0){
            $data[] = [
                'success' => true,
                'total' => 0,
                'title' => '',
                'date' => '',
                'message' => 'No hay notificaciones'
            ];
        } else {
            $data[] = [
                'success' => false,
                'message' => 'Error al obtener notificaciones'
            ];
        }

        return $data;
    }

    public function updateNotifications(){
        $query = "UPDATE notifications SET seen = 1 WHERE seen = 0";
        
        try{
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            
            if($stmt->affected_rows > 0){
                return array([
                    'success' => true,
                    'message' => 'Notificaciones actualizadas'
                ]);
            } else {
                return array([
                    'success' => false,
                    'message' => 'No se encontraron notificaciones por actualizar'
                ]);
            }
        } catch (Exception $e) {
            return array([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}