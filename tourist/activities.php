<?php
require_once '../includes/config.php';

if (!is_logged_in() || !is_tourist()) {
    redirect('../tourist/login.php');
}

$activities = get_activities();
?>

<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME . ' | ' . ucfirst(str_replace('.php', '', $current_page)); ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/custom.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container-fluid px-3 px-md-5">
            <a class="navbar-brand fw-bold fs-3" href="../index.php">
                
                <?php echo SITE_NAME; ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= $current_page == 'index.php' ? 'active' : '' ?>" href="../index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $current_page == 'lodges.php' ? 'active' : '' ?>" href="../lodges.php">Eco-Lodges</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $current_page == 'activities.php' ? 'active' : '' ?>" href="../activities.php">Activités</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $current_page == 'about.php' ? 'active' : '' ?>" href="../about.php">À propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $current_page == 'contact.php' ? 'active' : '' ?>" href="../contact.php">Contact</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <?php if (is_logged_in()): ?>
                        <?php if (is_admin()): ?>
                            <li class="nav-item">
                                <a class="nav-link <?= strpos($current_page, 'admin/') !== false ? 'active' : '' ?>" href="admin/dashboard.php">
                                    <i class="fas fa-user-shield me-1"></i> Admin
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link <?= strpos($current_page, 'tourist/') !== false ? 'active' : '' ?>" href="#">
                                    <i class="fas fa-user me-1"></i> Mon Compte
                                </a>
                            </li>
                            <li class="nav-item">
                                <span class="nav-link">
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-coins me-1"></i> <?= $_SESSION['points'] ?> pts
                                    </span>
                                </span>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../logout.php">
                                <i class="fas fa-sign-out-alt me-1"></i> Déconnexion
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $current_page == 'tourist/login.php' ? 'active' : '' ?>" href="tourist/login.php">
                                <i class="fas fa-sign-in-alt me-1"></i> Connexion
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $current_page == 'tourist/register.php' ? 'active' : '' ?>" href="tourist/register.php">
                                <i class="fas fa-user-plus me-1"></i> Inscription
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

<div class="container py-4">
    <h1 class="mb-4">Eco-Activities</h1>
    
    <div class="row">
        <?php foreach ($activities as $activity): ?>
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <img src="<?php echo $activity['image_url']; ?>" class="card-img-top" alt="<?php echo $activity['name']; ?>">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title"><?php echo $activity['name']; ?></h5>
                            <span class="badge bg-info"><?php echo $activity['duration']; ?></span>
                        </div>
                        <p class="card-text text-muted">
                            <i class="fas fa-map-marker-alt"></i> <?php echo $activity['location']; ?>
                        </p>
                        <p class="card-text"><?php echo $activity['description']; ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-primary fw-bold">$<?php echo $activity['price']; ?></span>
                                <span class="badge bg-warning text-dark ms-2">+<?php echo $activity['points_reward']; ?> pts</span>
                            </div>
                            <a href="bookings.php?activity_id=<?php echo $activity['id']; ?>" class="btn btn-sm btn-primary">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>