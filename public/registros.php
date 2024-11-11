<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Vendor\Esmefis\VerifySession;

session_start();

$verifyLocalSession = VerifySession::LocalSession($_COOKIE['SessionToken'] ?? null);

if(!$verifyLocalSession['success']){
    header('Location: index.php?session=expired');
    exit();
}
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
                    <h1 class="h3 mb-1 text-gray-800">Registros de los clientes</h1>
                    <p class="mb-4">Ver la lista de clientes y agregar comentarios</p>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- table Column -->
                        <div class="col-lg-12">

                            <!-- Circle Buttons -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Lista de clientes</h6>
                                </div>
                                <div class="card-body">             
                                    <p class="mb-4">Agrega más comentarios</p>                          
                                    <!-- Circle Buttons (Default) -->
                                    <hr class="divider">
                                    <table class="table" id="clientsTable">
                                        <thead>
                                            <tr>
                                            <th scope="col">ID</th>  
                                                <th scope="col">Nombre</th>                                                
                                                <th scope="col">Comentario más reciente</th>
                                                <th scope="col">Fecha de modificación</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Agregar</th>
                                                <th scope="col">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Second Column -->
                        <div class="col-lg-12">

                            <!-- Circle Buttons -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Lista de sin comentarios previos</h6>                                    
                                </div>
                                <div class="card-body">    
                                    <p class="mb-4">Agrega los primeros comentarios para los clientes potenciales</p>                                
                                    <!-- Circle Buttons (Default) -->
                                    <hr class="divider">
                                    <table class="table" id="noCommentsClientsTable">
                                        <thead>
                                            <tr>
                                            <th scope="col">ID</th>  
                                                <th scope="col">Nombre</th>                                                
                                                <th scope="col">WhatsApp/Tel</th>
                                                <th scope="col">Programa</th>
                                                <th scope="col">Tipo de programa</th>
                                                <th scope="col">Agregar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

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

    <!-- Modal status -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title fs-5" id="statusModal">Cambio de status</h5>
            <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body" id="comentsModalBody">
            <form id="statusForm">
                <div class="mb-3">
                    <label for="Clientstatus" class="form-label">Estatus</label>
                    <select class="form-control" id="clientstatus" name="clientstatus" required>
                        <option selected value="0">Selecciona una opción</option>
                        <option value="1" >PENDIENTE</option>
                        <option value="2" >INSCRITO</option>
                        <option value="3" >SEGUIMIENTO</option>
                        <option value="4" >DESCARTADO</option>
                    </select>
                    <input type="hidden" name="clientId" id="clientId" value="" readonly>
                </div>
                <button type="submit" class="btn btn-primary" id="">Realizar cambio</button>
            </form>  
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
    <script type="module" src="js/pages/records.js"></script>

</body>

</html>