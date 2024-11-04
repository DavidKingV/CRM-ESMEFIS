<?php
include_once __DIR__.'/../../vendor/autoload.php';
require_once __DIR__.'/../models/NotificationsModel.php';

use Vendor\Esmefis\DBConnection;

class NotificationsController {
    private $db;
    private $notifications;

    public function __construct(DBConnection $db) {
        $this->db = $db->getConnection();
        $this->notifications = new NotificationsModel($db);
    }

    public function getNotifications() {
        $response = $this->notifications->getNotifications();
        if($response[0]['success']){
           return $response;
        } else {
            return array(
                'success' => false,
                'message' => $response[0]['message']
            );
        }
    }

    public function createNotification($data) {
        return $this->notifications->createNotification($data);
    }

    public function updateNotifications() {
        return $this->notifications->updateNotifications();
    }

    public function deleteNotification($data) {
        return $this->notifications->deleteNotification($data);
    }
}