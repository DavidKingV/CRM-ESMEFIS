<?php
namespace Vendor\Esmefis;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

GetEnv::cargar();

class VerifySession {
    public static function LocalSession($jwt){
        
        $secretKey = $_ENV['SECRET_KEY'] ?? NULL;

        if(isset($_SESSION['UserID'])&&isset($_COOKIE['SessionToken'])){
            try {
                $decoded = JWT::decode($jwt, new Key($secretKey, 'HS256'));     
                return array('success' => true, 'UserID' => $decoded->UserID);
            } catch (\Exception $e) {
                return array('success' => false, 'message' => $e->getMessage());
            }
        }else{
            return array('success' => false, 'message' => 'No tiene permisos para realizar esta acción');
        }
    }
}