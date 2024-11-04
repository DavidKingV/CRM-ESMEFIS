<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__. '/../controllers/CustomerDataController.php';

use Vendor\Esmefis\DBConnection;

$connection = new DBConnection();
$customerDataController = new CustomerDataController($connection);

?>
<div class="p-5">
    <h2 class="fw-bolder">Clientes</h2>
    <p>Total de clientes registrados: <strong> <?php echo $customerDataController->getTotalClientes();; ?></strong></p>
    <a href="plantillas.php" class="btn btn-primary">Más detalles</a>
</div>