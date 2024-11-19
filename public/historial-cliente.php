<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__.'/../backend/controllers/CustomerDataController.php';

use Vendor\Esmefis\VerifySession;
use Vendor\Esmefis\DBConnection;
use Vendor\Esmefis\LocalCookie;

session_start();

$verifyLocalSession = VerifySession::LocalSession($_COOKIE['SessionToken'] ?? null);

if(!$verifyLocalSession['success']){
    header('Location: index.php?session=expired');
    exit();
}

$clientId=$_GET['client'] ?? null;
$connection = new DBConnection();
$clientData = new CustomerDataController($connection);

$clientInfo = $clientData->getCustomerInfo($clientId);

$setLocalStorage = LocalCookie::setTemporalCookie(intval($clientId));
?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Registros clientes</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include '../backend/views/MainMenu.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include '../backend/views/Header.php'; ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-1 text-gray-800">Historial de registros</h1>
                    <p class="mb-4">Lista de comentarios por cliente</p>

                    <?php if(!isset($clientId)){
                        echo 'Nada por aquí';
                    }else{?>
                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Información general del cliente</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <label><strong>Nombre:</strong></label>
                                            <p><?php echo $clientInfo['name'] ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label><strong>Teléfono:</strong></label>
                                            <p><?php echo $clientInfo['phone'] ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label><strong>Email:</strong></label>
                                            <p><?php echo $clientInfo['email'] ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label><strong>Programa:</strong></label>
                                            <p><?php echo $clientInfo['programLabel'] ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label><strong>Tipo de programa:</strong></label>
                                            <p><?php echo $clientInfo['program_type'] ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label><strong>Origen:</strong></label>
                                            <p><?php echo $clientInfo['origin'] ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label><strong>Fecha de creación:</strong></label>
                                            <p><?php echo $clientInfo['create_date'] ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label><strong>Status:</strong></label>
                                            <p><?php echo $clientInfo['labelStatus'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- table Column -->
                        <div class="col-lg-12">

                            <!-- Circle Buttons -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Historial completo de <label><?php echo $clientInfo['name'] ?></label></h6>
                                </div>
                                <div class="card-body">         
                                    <button id="addComment" data-bs-toggle="modal" data-bs-target="#comentsModal" data-id="<?php echo $clientInfo['id']; ?>" data-name="<?php echo $clientInfo['name']; ?>" class="btn btn-info btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-plus"></i>
                                        </span>
                                        <span class="text">Agregar comentario</span>
                                    </button>                                                     
                                    <!-- Circle Buttons (Default) -->
                                    <table class="table" id="historyComments">
                                        <thead>
                                            <tr>
                                            <th scope="col">ID</th>  
                                                <th scope="col">Comentario</th>
                                                <th scope="col">Fecha de creación</th>   
                                                <th scope="col">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                    <?php }?>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?php include '../backend/views/Footer.php'; ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Modal Coments -->
    <div class="modal fade" id="comentsModal" tabindex="-1" aria-labelledby="comentsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title fs-5" id="comentsModalLabel">Agregar comentarios</h5>
            <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body" id="comentsModalBody">
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
        </div>
    </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!--sweet alert-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!--datatables-->
    <script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.1.8/datatables.min.js"></script>

    <!--validate-->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
    <script type="module" src="js/utils/validate.js"></script>

    <!--page scripts-->
    <script type="module" src="js/pages/historyClient.js"></script>

</body>

</html>