<?php
include_once __DIR__ . "/../../vendor/autoload.php";
include_once __DIR__ . "/../controllers/CustomerDataController.php";

use Vendor\Esmefis\DBConnection;

$connection = new DBConnection();
$customerDataController = new CustomerDataController($connection);

if (isset($clientId)) {
    $customerInfo = $customerDataController->getCustomerInfo($clientId);

} else {
    $customerInfo = ['error' => 'No se ha especificado un ID'];
}
?>

<div class="card">
    <div class="card-header">
        Información del cliente
    </div>
    <div class="card-body">

        <div class="row py-2">
            <div class="col-6">
                <h4>Opciones</h4>
                <div class="btn-group py-4" role="group">
                    <button class="btn btn-warning">Editar</button>     
                    <button class="btn btn-danger">Eliminar</button>
                </div>
            </div>
            <div class="col-6">
                <h4>Status del cliente</h4>
                <div class="btn-group py-4" role="group">
                    <span class="badge rounded-pill text-bg-primary"><?php echo $customerInfo['labelStatus'] ?></span>
                </div>
            </div>
        </div>
        
        <div class="row py-2">
            <div class="col-4">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" value="<?php echo $customerInfo['nombre'] ?>" readonly>
            </div>
            <div class="col-4">
                <label for="telefono">Teléfono</label>
                <input type="text" class="form-control" id="telefono" value="<?php echo $customerInfo['telefono'] ?>" readonly>
            </div>
            <div class="col-4">
                <label for="email">Correo electrónico</label>
                <input type="text" class="form-control" id="email" value="<?php echo $customerInfo['email'] ?>" readonly>
            </div>
        </div>

        <div class="row py-2">
            <div class="col-4">
                <label for="licenciatura">Licenciatura</label>
                <input type="text" class="form-control" id="licenciatura" value="<?php echo $customerInfo['licenciatura'] ?>" readonly>
            </div>
            <div class="col-4">
                <label for="programa">Programa</label>
                <input type="text" class="form-control" id="programa" value="<?php echo $customerInfo['programa'] ?>" readonly>
            </div>
            <div class="col-4">
                <label for="origen">Origen</label>
                <input type="text" class="form-control" id="origen" value="<?php echo $customerInfo['origen'] ?>" readonly>
            </div>
        </div>

        <div class="row py-2">
            <div class="col-4">
                <label for="fecha_registro">Fecha de registro</label>
                <input type="text" class="form-control" id="fecha_registro" value="<?php echo $customerInfo['fecha_registro'] ?>" readonly>
            </div>
            <div class="col-4">
                <label for="estatus">Estatus</label>
                <input type="text" class="form-control" id="estatus" value="<?php echo $customerInfo['estatus'] ?>" readonly>
            </div>
            <div class="col-4">
                <label for="labelStatus">Label de estatus</label>
                <input type="text" class="form-control" id="labelStatus" value="<?php echo $customerInfo['labelStatus'] ?>" readonly>
            </div>
        </div>
    </div>
</div>
