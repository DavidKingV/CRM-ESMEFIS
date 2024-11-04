<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__. '/../controllers/CustomerDataController.php';

use Vendor\Esmefis\DBConnection;

$connection = new DBConnection();
$customerDataController = new CustomerDataController($connection);
list ($originName, $originCount) = $customerDataController->originsCount();
list ($program_name, $programsCount) = $customerDataController->programsCount();

?>

<div class="row">
    <!-- Area Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Clientes por programa</h6>            
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <?php if(!$program_name || !$programsCount){
                    echo "No hay datos para mostrar";
                }else{
                    ?>
                <div class="chart-area">
                    <canvas id="programs" style="display: block;width: 1037px;height: 320px;"></canvas>
                </div>
                <?php
                } ?>
            </div>
        </div>
    </div>

    <!-- Pie Chart -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Origenes</h6>            
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <?php if(!$originName || !$originCount){
                    echo "No hay datos para mostrar";
                }else{
                    ?>
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="origins"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Website
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Facebook
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-info"></i> WhatsApp
                        </span>
                    </div>
                    <?php
                }
                ?>
                
            </div>
        </div>
    </div>
</div>

<script type="module">
import { chartArea, chartBar } from '../public/js/utils/charts.js';

let labelOrigin = <?php echo json_encode($originName, JSON_UNESCAPED_UNICODE); ?> ;
let countOrigin = <?php echo json_encode($originCount); ?> ;

let program_name = <?php echo json_encode($program_name, JSON_UNESCAPED_UNICODE); ?> ;
let programsCount = <?php echo json_encode($programsCount); ?> ;

const piechart = document.getElementById("origins");
const barchart = document.getElementById("programs");


chartArea(piechart, labelOrigin, countOrigin);

chartBar(barchart, program_name, programsCount);
</script>