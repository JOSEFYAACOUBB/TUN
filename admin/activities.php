<?php
require_once '../includes/config.php';

if (!is_logged_in() || !is_admin()) {
    redirect('login.php');
}

$activities = get_activities();
?>

<?php include 'admin_header.php'; ?>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0">Gestion des activités</h2>
        <a href="add_activity.php" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nouvelle activité
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Liste des activités</h5>
                <div class="text-muted small">
                    <?php echo count($activities); ?> activité(s) au total
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            <?php if (empty($activities)): ?>
                <div class="text-center py-5">
                    <div class="icon-circle bg-primary-light mx-auto mb-3">
                        <i class="fas fa-mountain text-primary"></i>
                    </div>
                    <h4 class="h5 text-muted mb-3">Aucune activité disponible</h4>
                    <a href="add_activity.php" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Créer une activité
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0">Nom</th>
                                <th class="border-0">Localisation</th>
                                <th class="border-0 text-end">Prix</th>
                                <th class="border-0 text-center">Durée</th>
                                <th class="border-0 text-end">Points</th>
                                <th class="border-0 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($activities as $activity): ?>
                            <tr class="border-top">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="icon-circle bg-primary-light me-3">
                                            <i class="fas fa-globe text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0"><?php echo $activity['name']; ?></h6>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo $activity['location']; ?></td>
                                <td class="text-end"><?php echo $activity['price']; ?> DT</td>
                                <td class="text-center"><?php echo $activity['duration']; ?></td>
                                <td class="text-end text-success fw-bold">+<?php echo $activity['points_reward']; ?> pts</td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end">
                                        <a href="edit_activity.php?id=<?php echo $activity['id']; ?>" class="btn btn-sm btn-outline-primary me-2">
                                            <i class="fas fa-edit"></i> Modifier
                                        </a>
                                        <a href="delete_activity.php?id=<?php echo $activity['id']; ?>" class="btn btn-sm btn-outline-danger delete-btn">
                                            <i class="fas fa-trash"></i> Supprimer
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