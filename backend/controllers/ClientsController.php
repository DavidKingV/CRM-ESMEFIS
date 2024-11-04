<?php
require_once __DIR__.'/../../vendor/autoload.php';
require_once __DIR__.'/../models/ClientsModel.php';

use Vendor\Esmefis\DBConnection;

class ClientsController{
    private $db;
    private $clients;

    public function __construct(DBConnection $db) {
        $this->db = $db->getConnection();
        $this->clients = new ClientsModel($db);
    }

    public function addClient($data) {
        return $this->clients->addClient($data);
    }
}