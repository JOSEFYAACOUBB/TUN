<?php
require_once '../includes/config.php';

if (!is_logged_in() || !is_admin()) {
    redirect('login.php');
}

$bookings = get_all_bookings();
?>

<?php include 'admin_header.php'; ?>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-1">Gestion des Réservations</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item"><a href="dashboard.php">Tableau de bord</a></li>
                    <li class="breadcrumb-item active">Réservations</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Liste des réservations</h5>
            <div class="text-muted small">
                <?php echo count($bookings); ?> réservation(s) au total
            </div>
        </div>
        
        <div class="card-body p-0">
            <?php if (empty($bookings)): ?>
                <div class="text-center py-5">
                    <div class="icon-circle bg-primary-light mx-auto mb-3">
                        <i class="fas fa-calendar-times text-primary"></i>
                    </div>
                    <h4 class="h5 text-muted mb-3">Aucune réservation trouvée</h4>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0">Date</th>
                                <th class="border-0">Touriste</th>
                                <th class="border-0">Type</th>
                                <th class="border-0">Détails</th>
                                <th class="border-0">Statut</th>
                                <th class="border-0 text-end">Points</th>
                                <th class="border-0 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bookings as $booking): ?>
                            <tr class="border-top">
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold"><?php echo date('d/m/Y', strtotime($booking['booking_date'])); ?></span>
                                    </div>
                                </td>
                                <td><?php echo $booking['tourist_username']; ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $booking['lodge_name'] ? 'info' : 'primary'; ?>-light text-<?php echo $booking['lodge_name'] ? 'info' : 'primary'; ?>">
                                        <?php echo $booking['lodge_name'] ? 'Lodge' : 'Activité'; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($booking['lodge_name']): ?>
                                        <span class="d-flex align-items-center">
                                            <i class="fas fa-home me-2 text-muted"></i>
                                            <?php echo $booking['lodge_name']; ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="d-flex align-items-center">
                                            <i class="fas fa-hiking me-2 text-muted"></i>
                                            <?php echo $booking['activity_name']; ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-<?php
                                        echo $booking['status'] === 'confirmed' ? 'success' :
                                            ($booking['status'] === 'pending' ? 'warning' : 'danger');
                                        ?> rounded-pill px-3 py-1">
                                        <?php echo ucfirst($booking['status']); ?>
                                    </span>
                                </td>
                                <td class="text-end text-success fw-bold">+<?php echo $booking['points_earned']; ?></td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <?php if ($booking['status'] === 'pending'): ?>
                                            <a href="confirm_booking.php?id=<?php echo $booking['id']; ?>" class="btn btn-sm btn-success">
                                                <i class="fas fa-check me-1"></i>Confirmer
                                            </a>
                                        <?php endif; ?>
                                        <a href="delete_booking.php?id=<?php echo $booking['id']; ?>" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'admin_footer.php'; ?>