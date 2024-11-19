<?php  
require_once __DIR__ . '/../../vendor/autoload.php';

use Vendor\Esmefis\DBConnection;

class ApiModel{
    private $connection;

    public function __construct(DBConnection $dbConnection) {
        $this->connection = $dbConnection->getConnection();
    }

    public function sendData($name, $phone, $email, $program, $type_program, $origin) {
        // Activar el manejo de excepciones para mysqli
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        try {
            $query = "INSERT INTO potential_clients (name, phone, email, program, program_type, origin) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param("sssisi", $name, $phone, $email, $program, $type_program, $origin);
            $stmt->execute();
    
            if ($stmt->affected_rows > 0) {
                return [
                    'success' => true,
                    'message' => 'Datos enviados correctamente'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Error al enviar los datos' + $stmt->error
                ];
            }
        } catch (mysqli_sql_exception $e) {
            // Si ocurre una excepción por clave única duplicada
            if ($e->getCode() == 1062) { // 1062 es el código de error para 'Duplicate entry'
                return [
                    'success' => false,
                    'message' => 'Error: El cliente ya ha sido registrado anteriormente.'
                ];
            } else {
                // Para otros errores, puedes retornar un mensaje genérico o manejarlo de otra forma
                return [
                    'success' => false,
                    'message' => 'Error al enviar los datos, por favor intente de nuevo más tarde'
                ];
            }
        }
    }

    public function verifyProgram($program) {
        $query = "SELECT id, name FROM programs WHERE name = ? LIMIT 1";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("s", $program);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc(); // Solo llamamos a fetch_assoc una vez
            $programId = $row['id'];
            $programLabel = $row['name'];
            return [
                'success' => true,
                'program' => $programId,
                'program_label' => $programLabel
            ];
        }else {
            [
                'success' => false,
                'program' => null,
                'program_label' => null
            ];
        }
    }
}