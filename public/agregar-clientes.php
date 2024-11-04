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

    <title>Agregar clientes</title>

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
                    <h1 class="h3 mb-4 text-gray-800">Agregar cliente</h1>

                    <div class="row">

                        <div class="col-lg-6">

                            <!-- Circle Buttons -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Adición individual</h6>
                                </div>
                                <div class="card-body">
                                    <p>Agrega a un cliente de manera inidividual</p>
                                    <!-- Circle Buttons (Default) -->
                                    <hr class="divider">
                                    <form id="NewClientForm">
                                        <div class="form-group">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Nombre completo</label>
                                                <input type="text" class="form-control" id="name" name="name"> 
                                                <span></span>                                               
                                            </div>
                                            <div class="mb-3">
                                                <label for="phone" class="form-label">Teléfono</label>
                                                <input type="text" class="form-control" id="phone" name="phone">                                                
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Correo electrónico</label>
                                                <input type="text" class="form-control" id="email" name="email">
                                            </div>
                                            <div class="mb-3">
                                                <label for="program" class="form-label">Programa</label>
                                                <select class="form-control" id="program" name="program">
                                                    <option selected value="0">Selecciona una opción</option>
                                                    <option value="1">Esp. Rehabilitación Integral</option>
                                                    <option value="2">Diplomado Diagnostico del Pie e Implementación de Plantillas Ortopédicas</option>
                                                    <option value="3">Curso de Punción Seca</option>
                                                    <option value="4">Curso de Vendaje Neuromuscular</option>
                                                    <option value="5">Curso de Infiltración Articular</option>
                                                    <option value="6">Curso de Electroterapia</option>
                                                    <option value="7">Lic Fisioterapia</option>
                                                    <option value="8">Lic. Derecho</option>
                                                    <option value="9">Lic. Administración</option>
                                                    <option value="10">Lic. Contaduría</option>
                                                    <option value="11">Lic. Ciencias de la Educación</option>
                                                    <option value="12">Lic. Negocios Internacionales</option>
                                                    <option value="13">Lic. Turismo</option>
                                                    <option value="14">Lic. Diseño Gráfico</option>
                                                    <option value="15">Otro</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <div class="form-floating">
                                                    <label for="program_type" class="form-label">Tipo de programa</label>
                                                    <select class="form-control" id="program_type" name="program_type">
                                                        <option selected value="0">Selecciona una opción</option>
                                                        <option value="Licenciatura ejecutiva">Ejecutivo</option>
                                                        <option value="Titulación por experiencia">Titulación por experiencia</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="origin" class="form-label">Origen</label>
                                                <select class="form-control" id="origin" name="origin">
                                                    <option selected value="0">Selecciona una opción</option>
                                                    <option value="1">Web</option>
                                                    <option value="2">Facebook</option>
                                                    <option value="3">WhatsApp</option>
                                                </select>
                                            </div>
                                            <hr class="divider">
                                            <div class="mb-3">
                                                <div class="my-2"></div>
                                                <button type="submit" class="btn btn-success btn-icon-split">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-check"></i>
                                                    </span>
                                                    <span class="text">Agregar</span>
                                                </button>
                                            </div>
                                        </div>  
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Agregar desde Excel</h6>
                                </div>
                                <div class="card-body">
                                    <p>Agrega a varios clientes desde un archivo Excel. Puedes descargar la plantilla desde el siguiente boton: </p>
                                    <button id="downloadMock" class="btn btn-primary btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-download"></i>
                                        </span>
                                        <span class="text">Descargar plantilla Excel</span>
                                    </button>
                                    <hr class="divider">
                                    <form class="py-2" id="UploadExcelForm" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <div class="mb-3">
                                                <label for="formFile" class="form-label">Archivo Excel</label>
                                                <input class="form-control" type="file" id="formFile" accept=".xlsx, .xls, .csv" name="excelFile">
                                            </div>
                                            <hr class="divider">
                                            <div class="mb-3">
                                                <div class="my-2"></div>
                                                <button type="submit" class="btn btn-success btn-icon-split">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-check"></i>
                                                    </span>
                                                    <span class="text">Agregar</span>
                                                </button>
                                            </div>
                                        </div>  
                                    </form>
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

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!--sweet alert-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!--validate-->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
    <script type="module" src="js/utils/validate.js"></script>

    <!--page scripts-->
    <script type="module" src="js/pages/add-clients.js"></script>

</body>

</html>