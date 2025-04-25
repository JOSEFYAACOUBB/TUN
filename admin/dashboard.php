<?php
require_once '../includes/config.php';

if (!is_logged_in() || !is_admin()) {
    redirect('login.php');
}

$tourists_count = $pdo->query("SELECT COUNT(*) FROM tourists")->fetchColumn();
$total_points = $pdo->query("SELECT SUM(points) FROM tourists")->fetchColumn();
$bookings_count = $pdo->query("SELECT COUNT(*) FROM bookings")->fetchColumn();
$lodges_count = $pdo->query("SELECT COUNT(*) FROM eco_lodges")->fetchColumn();
?>

<?php include 'admin_header.php'; ?>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0">Tableau de bord</h2>
        <div class="text-muted small"><?php echo date(' F j, Y'); ?></div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4 g-4">
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <div class="icon-circle bg-primary-light mb-3">
                        <i class="fas fa-users text-primary"></i>
                    </div>
                    <h3 class="h5 text-muted">Touristes</h3>
                    <p class="h2 mb-0"><?php echo $tourists_count; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <div class="icon-circle bg-success-light mb-3">
                        <i class="fas fa-star text-success"></i>
                    </div>
                    <h3 class="h5 text-muted">Points totaux</h3>
                    <p class="h2 mb-0"><?php echo $total_points; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <div class="icon-circle bg-warning-light mb-3">
                        <i class="fas fa-calendar-check text-warning"></i>
                    </div>
                    <h3 class="h5 text-muted">Réservations</h3>
                    <p class="h2 mb-0"><?php echo $bookings_count; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <div class="icon-circle bg-info-light mb-3">
                        <i class="fas fa-hotel text-info"></i>
                    </div>
                    <h3 class="h5 text-muted">Éco-Lodges</h3>
                    <p class="h2 mb-0"><?php echo $lodges_count; ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Bookings -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Réservations récentes</h5>
                        <a href="bookings.php" class="btn btn-sm btn-outline-primary">Voir tout</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <?php
                    $recent_bookings = get_all_bookings();
                    $recent_bookings = array_slice($recent_bookings, 0, 5);
                    ?>
                    
                    <?php if (empty($recent_bookings)): ?>
                        <div class="alert alert-light m-3">
                            Aucune réservation trouvée.
                        </div>
                    <?php else: ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($recent_bookings as $booking): ?>
                            <div class="list-group-item border-0 py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">
                                            <?php echo $booking['tourist_username']; ?>
                                            <span class="badge ms-2 bg-<?php 
                                                echo $booking['status'] === 'confirmed' ? 'success-light text-success' : 
                                                     ($booking['status'] === 'pending' ? 'warning-light text-warning' : 'danger-light text-danger'); 
                                            ?>">
                                                <?php echo ucfirst($booking['status']); ?>
                                            </span>
                                        </h6>
                                        <small class="text-muted">
                                            <?php echo date('M j, Y', strtotime($booking['booking_date'])); ?> • 
                                            <?php echo $booking['lodge_name'] ?: $booking['activity_name']; ?>
                                        </small>
                                    </div>
                                    <div class="text-success fw-bold">+<?php echo $booking['points_earned']; ?> pts</div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Recent Tourists -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Touristes récents</h5>
                        <a href="tourists.php" class="btn btn-sm btn-outline-primary">Voir tout</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <?php
                    $recent_tourists = get_all_tourists();
                    $recent_tourists = array_slice($recent_tourists, 0, 5);
                    ?>
                    
                    <?php if (empty($recent_tourists)): ?>
                        <div class="alert alert-light m-3">
                            Aucun touriste trouvé.
                        </div>
                    <?php else: ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($recent_tourists as $tourist): ?>
                            <div class="list-group-item border-0 py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1"><?php echo $tourist['username']; ?></h6>
                                        <small class="text-muted"><?php echo $tourist['email']; ?></small>
                                    </div>
                                    <div>
                                        <span class="badge bg-primary-light text-primary">
                                            <?php echo isset($tourist['registration_date']) ? date('M j, Y', strtotime($tourist['registration_date'])) : 'N/A'; ?>
                                        </span>
                                        <span class="badge bg-success-light text-success ms-2">
                                            <?php echo $tourist['points']; ?> pts
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'admin_footer.php'; ?>