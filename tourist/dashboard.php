<?php
require_once '../includes/config.php';

if (!is_logged_in() || !is_tourist()) {
    redirect('../tourist/login.php');
}

$tourist_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$points = $_SESSION['points'];

$bookings = get_tourist_bookings($tourist_id);
$recent_bookings = array_slice($bookings, 0, 3);
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
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h5 class="card-title">Bienvenue</h5>
                    <h2 class="mb-0"><?php echo htmlspecialchars($username); ?></h2>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-body text-center">
                    <h5 class="card-title">Vos Points Éco</h5>
                    <div class="points-display mb-3"><?php echo $points; ?></div>
                    <p>Gagnez plus de points en réservant des options écologiques</p>
                    
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Actions rapides</h5>
                    <div class="d-grid gap-2">
                        <a href="../lodges.php" class="btn btn-primary">Réserver un lodge</a>
                        <a href="../activities.php" class="btn btn-outline-primary">Trouver des activités</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Vos réservations récentes</h5>
                        <a href="bookings.php" class="btn btn-sm btn-outline-primary">Voir tout</a>
                    </div>
                    
                    <?php if (empty($recent_bookings)): ?>
                        <div class="alert alert-info">
                            Vous n'avez aucune réservation pour le moment. <a href="bookings.php" class="alert-link">Réservez votre premier séjour éco-responsable ou activité</a>.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Réservation</th>
                                        <th>Statut</th>
                                        <th>Points</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recent_bookings as $booking): ?>
                                        <tr>
                                            <td><?php echo date('j M Y', strtotime($booking['booking_date'])); ?></td>
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
                                                    <?php echo ucfirst($booking['status'] === 'confirmed' ? 'confirmé' : 
                                                              ($booking['status'] === 'pending' ? 'en attente' : 'annulé')); ?>
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
            
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Conseils pour un voyage éco-responsable</h5>
                    <div class="accordion" id="tipsAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Réduisez votre empreinte carbone
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#tipsAccordion">
                                <div class="accordion-body">
                                    <ul>
                                        <li>Choisissez des hébergements avec certifications écologiques</li>
                                        <li>Utilisez les transports en commun ou marchez quand possible</li>
                                        <li>Apportez une bouteille d'eau et un sac réutilisables</li>
                                        <li>Compensez les émissions de votre vol</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Soutenez les communautés locales
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#tipsAccordion">
                                <div class="accordion-body">
                                    <ul>
                                        <li>Achetez sur les marchés locaux et auprès des artisans</li>
                                        <li>Mangez dans des restaurants locaux</li>
                                        <li>Choisissez des visites et activités communautaires</li>
                                        <li>Apprenez quelques mots de la langue locale</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Maximisez vos points
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#tipsAccordion">
                                <div class="accordion-body">
                                    <ul>
                                        <li>Réservez des lodges éco-certifiés (+50 points)</li>
                                        <li>Participez à des visites guidées écologiques (+30 points)</li>
                                        <li>Utilisez des transports durables (+20 points)</li>
                                        <li>Écrivez des avis sur les spots éco (+10 points)</li>
                                        <li>Partagez votre expérience sur les réseaux sociaux (+5 points)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>