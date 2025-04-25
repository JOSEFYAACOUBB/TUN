<?php
require_once '../includes/config.php';

if (!is_logged_in() || !is_tourist()) {
    redirect('../tourist/login.php');
}

$tourist_id = $_SESSION['user_id'];
$bookings = get_tourist_bookings($tourist_id);

// Gestion d'une nouvelle réservation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lodge_id = isset($_POST['lodge_id']) ? (int)$_POST['lodge_id'] : null;
    $activity_id = isset($_POST['activity_id']) ? (int)$_POST['activity_id'] : null;
    $booking_date = $_POST['booking_date'];
    
    if (create_booking($tourist_id, $lodge_id, $activity_id, $booking_date)) {
        $_SESSION['primary_message'] = 'Réservation créée avec succès !';
        redirect('bookings.php');
    } else {
        $_SESSION['error_message'] = 'Échec de la création de la réservation. Veuillez réessayer.';
    }
}

// Obtenir le lodge ou l'activité pour une nouvelle réservation
$lodge = null;
$activity = null;
if (isset($_GET['lodge_id'])) {
    $lodge = get_lodge_by_id((int)$_GET['lodge_id']);
} elseif (isset($_GET['activity_id'])) {
    $activity = get_activity_by_id((int)$_GET['activity_id']);
}
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
                                <a class="nav-link <?= strpos($current_page, 'tourist/') !== false ? 'active' : '' ?>" href="">
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
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?php echo isset($lodge) ? 'Réserver ' . $lodge['name'] : (isset($activity) ? 'Réserver ' . $activity['name'] : 'Vos Réservations'); ?></h1>
        <?php if (!isset($lodge) && !isset($activity)): ?>
            <a href="../lodges.php" class="btn btn-primary">Nouvelle réservation</a>
        <?php endif; ?>
    </div>
    
    <?php if (isset($lodge) || isset($activity)): ?>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Nouvelle réservation</h5>
                        
                        <form method="POST">
                            <?php if ($lodge): ?>
                                <input type="hidden" name="lodge_id" value="<?php echo $lodge['id']; ?>">
                                <div class="mb-3">
                                    <label class="form-label">Lodge</label>
                                    <input type="text" class="form-control" value="<?php echo $lodge['name']; ?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Emplacement</label>
                                    <input type="text" class="form-control" value="<?php echo $lodge['location']; ?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Prix par nuit</label>
                                    <input type="text" class="form-control" value="<?php echo $lodge['price_per_night']; ?> DT" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Gagnez +50 points</label>
                                </div>
                            <?php else: ?>
                                <input type="hidden" name="activity_id" value="<?php echo $activity['id']; ?>">
                                <div class="mb-3">
                                    <label class="form-label">Activité</label>
                                    <input type="text" class="form-control" value="<?php echo $activity['name']; ?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Emplacement</label>
                                    <input type="text" class="form-control" value="<?php echo $activity['location']; ?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Prix</label>
                                    <input type="text" class="form-control" value="<?php echo $activity['price']; ?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Gagnez +<?php echo $activity['points_reward']; ?> points</label>
                                </div>
                            <?php endif; ?>
                            
                            <div class="mb-3">
                                <label for="booking_date" class="form-label">Date de réservation</label>
                                <input type="date" class="form-control" id="booking_date" name="booking_date" required>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Confirmer la réservation</button>
                                <a href="<?php echo $lodge ? '../lodges.php' : '../activities.php'; ?>" class="btn btn-outline-secondary">Annuler</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Vos réservations</h5>
                
                <?php if (empty($bookings)): ?>
                    <div class="alert alert-info">
                        Vous n'avez aucune réservation pour le moment. <a href="../lodges.php" class="alert-link">Réservez votre premier séjour éco-responsable ou activité</a>.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Élément</th>
                                    <th>Statut</th>
                                    <th>Points</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($bookings as $booking): ?>
                                    <tr>
                                        <td><?php echo date('j M Y', strtotime($booking['booking_date'])); ?></td>
                                        <td><?php echo $booking['lodge_name'] ? 'Lodge' : 'Activité'; ?></td>
                                        <td>
                                            <?php if ($booking['lodge_name']): ?>
                                                <?php echo $booking['lodge_name']; ?>
                                            <?php else: ?>
                                                <?php echo $booking['activity_name']; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?php 
                                                echo $booking['status'] === 'confirmed' ? 'primary' : 
                                                     ($booking['status'] === 'pending' ? 'warning' : 'danger'); 
                                            ?>">
                                                <?php echo $booking['status'] === 'confirmed' ? 'Confirmé' : 
                                                      ($booking['status'] === 'pending' ? 'En attente' : 'Annulé'); ?>
                                            </span>
                                        </td>
                                        <td class="text-primary">+<?php echo $booking['points_earned']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>