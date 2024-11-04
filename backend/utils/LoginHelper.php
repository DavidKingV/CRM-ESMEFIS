<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Vendor\Emails\GetEnv;

class SessionHelper {
    public static function createUserSession($user) {
        session_set_cookie_params($_ENV['LIFE_TIME']);
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $payLoad = [
            'UserID' => $user['id'],
            'UserName' => $user['user']
        ];
        
        try {
            $jsonWT = JWT::encode($payLoad, $_ENV['SECRET_KEY'], 'HS256');
        } catch (Exception $e) {
            return false;
        }

        setcookie('SessionToken', $jsonWT, time() + $_ENV['LIFE_TIME'], "/", "", true, true);

        $_SESSION['UserID'] = $user['id'];
        $_SESSION['UserName'] = $user['user'];

        return isset($_SESSION['UserID']);
    }

    public static function destroyUserSession() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        setcookie('SessionToken', '', time() - 3600, "/", "", true, true);
        session_unset();
        session_destroy();

        return session_status() === PHP_SESSION_NONE;
    }
}

?>