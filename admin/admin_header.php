<?php
require_once '../includes/config.php';

if (!is_logged_in() || !is_admin()) {
    redirect('login.php');
}

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME . ' | Admin - ' . ucfirst(str_replace('.php', '', $current_page)); ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar Navigation -->
        <nav id="sidebar">
        <div class="sidebar-brand">
        </div>
            <div class="sidebar-brand">
            </div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'dashboard.php' ? 'active' : '' ?>" href="dashboard.php">
                        <i class="fas fa-chart-line"></i>
                        <span>Tableau de bord</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'activities.php' ? 'active' : '' ?>" href="activities.php">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Activites</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'lodges.php' ? 'active' : '' ?>" href="lodges.php">
                        <i class="fas fa-hotel"></i>
                        <span>Hébergements</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'bookings.php' ? 'active' : '' ?>" href="bookings.php">
                        <i class="fas fa-calendar-check"></i>
                        <span>Réservations</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'tourists.php' ? 'active' : '' ?>" href="tourists.php">
                        <i class="fas fa-users"></i>
                        <span>Touristes</span>
                    </a>
                </li>
                <li class="nav-item mt-4">
                    <a class="nav-link text-danger" href="../logout.php">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Déconnexion</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="flex-grow-1">
            <header class="admin-header">
                <div class="header-content">
                    <h4 class="mb-0">
                        <i class="fas <?php 
                            if ($current_page == 'dashboard.php') echo 'fas fa-chart-line';
                            elseif ($current_page == 'lodges.php') echo 'fa-hotel';
                            elseif ($current_page == 'bookings.php') echo 'fa-calendar-check';
                            elseif ($current_page == 'tourists.php') echo 'fa-users';
                            elseif ($current_page == 'activities.php') echo 'fas fa-tachometer-alt';
                        ?> text-primary me-2"></i>
                        <?php echo ucfirst(str_replace('.php', '', $current_page)); ?>
                    </h4>
                </div>
            </header>

            