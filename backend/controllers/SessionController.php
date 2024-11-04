<?php
include_once __DIR__ . '/../../vendor/autoload.php';
include_once __DIR__ . '/../models/SessionModel.php';
include_once __DIR__ . '/../utils/LoginHelper.php';

use Vendor\Esmefis\DBConnection;

class SessionController{
    private $loginModel;

    public function __construct(DBConnection $connection) {
        $this->loginModel = new SessionModel($connection);
    }

    public function login($loginData) {
        $user = $loginData['user'];
        $password = $loginData['password'];

        $userData = $this->loginModel->getByUser($user);
        if (!$userData) {
            return $this->errorResponse('Usuario o contraseña incorrectos');
        }

        if ($this->isPasswordValid($userData, $password)) {
            return $this->successfulLogin($userData);
        }

        if ($this->needsPasswordHashing($userData, $password)) {
            return $this->updatePasswordAndLogin($userData, $password);
        }

        return $this->errorResponse('Usuario o contraseña incorrectos');
    }

    private function isPasswordValid($userData, $password) {
        return $userData['hashed_password'] !== null && password_verify($password, $userData['hashed_password']);
    }

    private function needsPasswordHashing($userData, $password) {
        return $userData['hashed_password'] === null && $userData['password'] === $password;
    }

    private function updatePasswordAndLogin($userData, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        if ($this->updateHashedPassword($userData['id'], $hashedPassword)) {
            return $this->successfulLogin($userData);
        }
        return $this->errorResponse('Error al actualizar la contraseña, por favor intente de nuevo más tarde');
    }

    private function successfulLogin($userData) {
        SessionHelper::createUserSession($userData);
        return [
            'success' => true,
            'message' => 'Inicio de sesión exitoso',
            'UserID' => $userData['id']
        ];
    }

    private function successfulLogout() {
        SessionHelper::destroyUserSession();
        return [
            'success' => true,
            'message' => 'Cierre de sesión exitoso'
        ];
    }

    private function errorResponse($message) {
        return [
            'success' => false,
            'message' => $message
        ];
    }

    private function updateHashedPassword($userId, $hashedPassword) {
        // Implementa la lógica para actualizar la contraseña en la base de datos
        return $this->loginModel->updateHashedPassword($userId, $hashedPassword);
    }

    public function logout(){
        return $this->successfulLogout();
    }
}