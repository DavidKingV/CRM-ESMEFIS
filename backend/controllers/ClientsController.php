<?php
require_once __DIR__.'/../../vendor/autoload.php';
require_once __DIR__.'/../models/ClientsModel.php';

use Vendor\Esmefis\DBConnection;
use PhpOffice\PhpSpreadsheet\IOFactory;

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

    public function uploadClientsExcel(){
        $errorRecords = [];
        $successRecords = 0;
    
        if(isset($_FILES['excelFile'])){
            $filePath = $_FILES['excelFile']['tmp_name'];
            $spreadsheet = IOFactory::load($filePath);
            $sheet = $spreadsheet->getActiveSheet();
    
            foreach($sheet->getRowIterator() as $rowIndex => $row) {
                // Saltar la primera fila (encabezados)
                if ($rowIndex == 1) {
                    continue;
                }
    
                $rowData = [];
                $isEmptyRow = true; // Suponer que la fila está vacía
    
                foreach ($row->getCellIterator() as $cell) {
                    $cellValue = $cell->getValue();
    
                    // Si encontramos algún valor no vacío, la fila no está vacía
                    if (!empty($cellValue) && $cellValue !== null) {
                        $isEmptyRow = false;
                    }
    
                    // Agregar el valor de la celda a rowData
                    $rowData[] = $cellValue;
                }
    
                // Saltar filas vacías
                if ($isEmptyRow) {
                    continue;
                }
    
                try {
                    $this->clients->addClientFromExcel($rowData);
                    $successRecords++;
                } catch (Exception $e) {
                    $errorRecords[] = [
                        'row' => $rowIndex,
                        'error' => $e->getMessage()
                    ];
                }
            }
    
            if(count($errorRecords) > 0){
                return [
                    'success' => false,
                    'message' => 'Algunos registros no pudieron ser agregados',
                    'errors' => $errorRecords,
                    'successRecords' => $successRecords
                ];
            } else {
                return [
                    'success' => true,
                    'message' => 'Todos los registros fueron agregados correctamente'
                ];
            }
        } else {
            return ['success' => false, 'message' => 'No se ha subido ningún archivo'];
        }
    }
}