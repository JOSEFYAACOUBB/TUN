<?php
require_once '../includes/config.php';

if (!is_logged_in() || !is_admin()) {
    redirect('login.php');
}

$tourists = get_all_tourists();
?>

<?php include 'admin_header.php'; ?>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-1">Gestion des Touristes</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item"><a href="dashboard.php">Tableau de bord</a></li>
                    <li class="breadcrumb-item active">Touristes</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Liste des touristes</h5>
            <div class="text-muted small">
                <?php echo count($tourists); ?> touriste(s) enregistré(s)
            </div>
        </div>
        
        <div class="card-body p-0">
            <?php if (empty($tourists)): ?>
                <div class="text-center py-5">
                    <div class="icon-circle bg-primary-light mx-auto mb-3">
                        <i class="fas fa-users text-primary"></i>
                    </div>
                    <h4 class="h5 text-muted mb-3">Aucun touriste trouvé</h4>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0">Touriste</th>
                                <th class="border-0">Email</th>
                                <th class="border-0">Inscription</th>
                                <th class="border-0 text-end">Points</th>
                                <th class="border-0 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tourists as $tourist): ?>
                            <tr class="border-top">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle bg-primary-light me-3">
                                            <span class="initials"><?php echo getInitials($tourist['username']); ?></span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0"><?php echo $tourist['username']; ?></h6>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo $tourist['email']; ?></td>
                                <td>
                                    <?php if (isset($tourist['registration_date'])): ?>
                                        <div class="d-flex flex-column">
                                            <span><?php echo date('d/m/Y', strtotime($tourist['registration_date'])); ?></span>
                                            <small class="text-muted"><?php echo date('H:i', strtotime($tourist['registration_date'])); ?></small>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <span class="badge bg-success-light text-success rounded-pill px-3 py-1">
                                        <?php echo $tourist['points']; ?> pts
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="edit_tourist.php?id=<?php echo $tourist['id']; ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="delete_tourist.php?id=<?php echo $tourist['id']; ?>" class="btn btn-sm btn-outline-danger delete-btn">
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

<script>
// Confirmation avant suppression
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        if (!confirm('Êtes-vous sûr de vouloir supprimer ce touriste ? Cette action est irréversible.')) {
            e.preventDefault();
        }
    });
});
</script>

<?php include 'admin_footer.php'; ?>