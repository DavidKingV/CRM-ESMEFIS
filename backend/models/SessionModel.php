<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Vendor\Esmefis\DBConnection;

class SessionModel{
    private $connection;

    public function __construct(DBConnection $dbConnection) {
        $this->connection = $dbConnection->getConnection();
    }

    public function getByUser($user) {
        return $this->executeSingleResultQuery(
            "SELECT * FROM login_users WHERE user = ?",
            's',
            [$user]
        );
    }

    public function updateHashedPassword($userID, $hashedPassword) {
        return $this->executeUpdateQuery(
            "UPDATE login_users SET hashed_password = ? WHERE id = ?",
            'si',
            [$hashedPassword, $userID]
        );
    }

    private function executeSingleResultQuery($query, $types, $params) {
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }

    private function executeUpdateQuery($query, $types, $params) {
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $affectedRows = $stmt->affected_rows;
        $stmt->close();
        return $affectedRows > 0;
    }
}