<?php
include_once __DIR__.'/../../vendor/autoload.php';
include_once __DIR__.'/../controllers/NotificationsController.php';

use Vendor\Esmefis\DBConnection;

$connection = new DBConnection();
$notifications = new NotificationsController($connection);
$notifications = $notifications->getNotifications();
?>

<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

<!-- Sidebar Toggle (Topbar) -->
<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
    <i class="fas fa-bars"></i>
</button>

<!-- Topbar Navbar -->
<ul class="navbar-nav ml-auto">

    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
    <li class="nav-item dropdown no-arrow d-sm-none">
        <button class="nav-link dropdown-toggle" href="" id="searchDropdown" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-search fa-fw"></i>
        </button>
        <!-- Dropdown - Messages -->
        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
            aria-labelledby="searchDropdown">
            <form class="form-inline mr-auto w-100 navbar-search">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small"
                        placeholder="Search for..." aria-label="Search"
                        aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </li>

    <!-- Nav Item - Alerts -->
    <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" id="alertsDropdown" role="button"
            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell fa-fw"></i>
            <!-- Counter - Alerts -->
            <span class="badge badge-danger badge-counter" id="notiCount"><?php echo $notifications[0]['total'] ?? 0 ?></span>
        </a>
        <!-- Dropdown - Alerts -->
        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
            aria-labelledby="alertsDropdown">
            <h6 class="dropdown-header">
                Centro de notificaciones
            </h6>
            <?php
            if($notifications[0]['success'] && $notifications[0]['total'] > 0){
                foreach($notifications as $notification){
                    echo '<a class="dropdown-item d-flex align-items-center">
                    <div class="mr-3">
                        <div class="icon-circle bg-primary">
                            <i class="fas fa-comment-medical text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">'.$notification['date'].'</div>
                        <span class="font-weight-bold">'.$notification['title'].'</span>
                    </div>
                </a>';
                }
            } else {
                echo '<a class="dropdown-item d-flex align-items-center" >
                    <div class="mr-3">
                        <div class="icon-circle bg-primary">
                            <i class="far fa-times-circle text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">No hay notificaciones</div>
                    </div>
                </a>';
            }
            ?>
            <!--<a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>-->
        </div>
    </li>

    <div class="topbar-divider d-none d-sm-block"></div>

    <!-- Nav Item - User Information -->
    <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['UserName'] ?></span>
            <img class="img-profile rounded-circle"
                src="img/undraw_profile.svg">
        </a>
        <!-- Dropdown - User Information -->
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
            aria-labelledby="userDropdown">
            <!--<a class="dropdown-item" href="#">
                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                Profile
            </a>
            <a class="dropdown-item" href="#">
                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                Settings
            </a>
            <a class="dropdown-item" href="#">
                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                Activity Log
            </a>
            <div class="dropdown-divider"></div>-->
            <button class="dropdown-item" id="closeSession">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                Cerrar sesión
            </button>
        </div>
    </li>

</ul>

</nav>
<!-- End of Topbar -->

<script type="module" src="js/utils/notifications.js"></script>
<script type="module" src="js/utils/closeSession.js"></script>