<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__. '/../controllers/CustomerDataController.php';

use Vendor\Esmefis\DBConnection;

$connection = new DBConnection();
$customerDataController = new CustomerDataController($connection);
list ($nombresLicenciaturas, $cantidades) = $customerDataController->getTotalLicenciaturas();

?>

<canvas id="licenciaturasOrden"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

    const ctx = document.getElementById('licenciaturasOrden');

    var labelsProgramas = <?php echo json_encode($nombresLicenciaturas, JSON_UNESCAPED_UNICODE); ?> ;
    var cantidadesProgramas = <?php echo json_encode($cantidades); ?> ;

    function generateRandomColor() {
        const r = Math.floor(Math.random() * 256);
        const g = Math.floor(Math.random() * 256);
        const b = Math.floor(Math.random() * 256);
        return `rgba(${r}, ${g}, ${b}, 0.7)`;  // Color con transparencia
    }

    const colorsProgramas = cantidadesProgramas.map(() => generateRandomColor());

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labelsProgramas,
            datasets: [{
                label: 'Cantidad de clientes por Programa',
                data: cantidadesProgramas,
                backgroundColor: colorsProgramas,  // Asignar colores a cada barra
                borderColor: colorsProgramas,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                    stepSize: 1  // Incrementos de 1 en 1 en la escala del eje Y
                    }
                }
            }
        }
    });

</script>