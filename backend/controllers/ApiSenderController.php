<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__.'/../models/ApiModel.php';

use Vendor\Esmefis\DBConnection;

class ApiSender{
    private $apiModel;

    public function __construct(DBConnection $dbConnection) {
        $this->apiModel = new ApiModel($dbConnection);
    }

    public static function sendDataToApi($data){
        $name = $data['name'];
        $phone = $data['phone'];
        $email = $data['email'];
        $program = $data['program'];
        $type_program = $data['type_program'];
        $origin = $data['origin'];

        $apiModel = new ApiModel(new DBConnection());
        $apiResponse = $apiModel->sendData($name, $phone, $email, $program, $type_program, $origin);

        if($apiResponse['success']){
            return [
                'success' => true,
                'message' => $apiResponse['message']
            ];
        }else{
            return [
                'success' => false,
                'message' => $apiResponse['message']
            ];
        }
    }   

    public static function verifyProgram($program){
        $apiModel = new ApiModel(new DBConnection());
        return $apiModel->verifyProgram($program);
    }

}