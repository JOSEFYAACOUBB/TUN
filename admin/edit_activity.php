<?php
require_once '../includes/config.php';
require_once 'admin_header.php';

if (!isset($_GET['id'])) {
    die("ID d'activité manquant.");
}

$activity_id = (int)$_GET['id'];

// Récupérer les données de l'activité
$stmt = $pdo->prepare("SELECT * FROM activities WHERE id = ?");
$stmt->execute([$activity_id]);
$activity = $stmt->fetch();

if (!$activity) {
    die("Activité non trouvée.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $location = trim($_POST['location']);
    $description = trim($_POST['description']);
    $price = (float)$_POST['price'];
    $duration = trim($_POST['duration']);
    $points_reward = (int)$_POST['points_reward'];

    $stmt = $pdo->prepare("UPDATE activities SET name = ?, location = ?, description = ?, price = ?, duration = ?, points_reward = ? WHERE id = ?");
    $stmt->execute([$name, $location, $description, $price, $duration, $points_reward, $activity_id]);

    $_SESSION['success_message'] = "Activité mise à jour avec succès !";
    redirect('activities.php');
    exit;
}
?>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-1">Modifier une activité</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item"><a href="dashboard.php">Tableau de bord</a></li>
                    <li class="breadcrumb-item"><a href="activities.php">Activités</a></li>
                    <li class="breadcrumb-item active">Modifier</li>
                </ol>
            </nav>
        </div>
        <a href="activities.php" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0">
            <h5 class="mb-0">Informations de l'activité</h5>
        </div>
        <div class="card-body">
            <form method="POST" class="needs-validation" novalidate>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom *</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($activity['name']) ?>" required>
                            <div class="invalid-feedback">Veuillez saisir un nom valide.</div>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Lieu *</label>
                            <input type="text" class="form-control" id="location" name="location" value="<?= htmlspecialchars($activity['location']) ?>" required>
                            <div class="invalid-feedback">Veuillez saisir un lieu.</div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description *</label>
                            <textarea class="form-control" id="description" name="description" rows="5" required><?= htmlspecialchars($activity['description']) ?></textarea>
                            <div class="invalid-feedback">Veuillez saisir une description.</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="price" class="form-label">Prix (DT) *</label>
                            <div class="input-group">
                                <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?= htmlspecialchars($activity['price']) ?>" required>
                                <span class="input-group-text">DT</span>
                            </div>
                            <div class="invalid-feedback">Veuillez saisir un prix valide.</div>
                        </div>
                        <div class="mb-3">
                            <label for="duration" class="form-label">Durée *</label>
                            <input type="text" class="form-control" id="duration" name="duration" value="<?= htmlspecialchars($activity['duration']) ?>" required>
                            <div class="invalid-feedback">Veuillez saisir une durée.</div>
                        </div>
                        <div class="mb-3">
                            <label for="points_reward" class="form-label">Points de récompense *</label>
                            <input type="number" class="form-control" id="points_reward" name="points_reward" value="<?= htmlspecialchars($activity['points_reward']) ?>" required>
                            <div class="invalid-feedback">Veuillez saisir un nombre de points valide.</div>
                        </div>
                    </div>
                    <div class="col-12 mt-4">
                        <div class="d-flex justify-content-end gap-3">
                            <a href="activities.php" class="btn btn-outline-secondary">Annuler</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Enregistrer
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once 'admin_footer.php'; ?>
