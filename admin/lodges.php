<?php
require_once '../includes/config.php';

if (!is_logged_in() || !is_admin()) {
    redirect('login.php');
}

$lodges = get_eco_lodges();
?>

<?php include 'admin_header.php'; ?>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-1">Gestion des Éco-Lodges</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item"><a href="dashboard.php">Tableau de bord</a></li>
                    <li class="breadcrumb-item active">Éco-Lodges</li>
                </ol>
            </nav>
        </div>
        <a href="add_lodge.php" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Ajouter un logement
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Liste des lodges</h5>
            <div class="text-muted small">
                <?php echo count($lodges); ?> logement(s) au total
            </div>
        </div>
        
        <div class="card-body p-0">
            <?php if (empty($lodges)): ?>
                <div class="text-center py-5">
                    <div class="icon-circle bg-primary-light mx-auto mb-3">
                        <i class="fas fa-home text-primary"></i>
                    </div>
                    <h4 class="h5 text-muted mb-3">Aucun éco-lodge disponible</h4>
                    <a href="add_lodge.php" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Ajouter un logement
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0">Nom</th>
                                <th class="border-0">Localisation</th>
                                <th class="border-0 text-end">Prix/Nuit</th>
                                <th class="border-0">Durabilité</th>
                                <th class="border-0 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lodges as $lodge): ?>
                            <tr class="border-top">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="icon-circle bg-primary-light me-3">
                                            <i class="fas fa-home text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0"><?php echo $lodge['name']; ?></h6>

                                        </div>
                                    </div>
                                </td>
                                <td><?php echo $lodge['location']; ?></td>
                                <td class="text-end"><?php echo $lodge['price_per_night']; ?> DT</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 me-3" style="height: 6px;">
                                            <div class="progress-bar bg-success" role="progressbar" 
                                                 style="width: <?php echo $lodge['sustainability_score']; ?>%" 
                                                 aria-valuenow="<?php echo $lodge['sustainability_score']; ?>" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100">
                                            </div>
                                        </div>
                                        <span class="text-nowrap"><?php echo $lodge['sustainability_score']; ?>%</span>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end">
                                        <a href="edit_lodge.php?id=<?php echo $lodge['id']; ?>" class="btn btn-sm btn-outline-primary me-2">
                                            <i class="fas fa-edit"></i> Modifier
                                        </a>
                                        <a href="delete_lodge.php?id=<?php echo $lodge['id']; ?>" class="btn btn-sm btn-outline-danger delete-btn">
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