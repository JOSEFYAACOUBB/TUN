<?php
require_once '../includes/config.php';

if (!is_logged_in() || !is_admin()) {
    redirect('login.php');
}

if (!isset($_GET['id'])) {
    redirect('tourists.php');
}

$tourist_id = (int)$_GET['id'];

// Get tourist data
$stmt = $pdo->prepare("SELECT * FROM tourists WHERE id = ?");
$stmt->execute([$tourist_id]);
$tourist = $stmt->fetch();

if (!$tourist) {
    redirect('tourists.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $full_name = trim($_POST['full_name']);
    $phone = trim($_POST['phone']);
    $country = trim($_POST['country']);
    $points = (int)$_POST['points'];

    // Check if username or email already exists (excluding current tourist)
    $stmt = $pdo->prepare("SELECT id FROM tourists WHERE (username = ? OR email = ?) AND id != ?");
    $stmt->execute([$username, $email, $tourist_id]);
    if ($stmt->fetch()) {
        $_SESSION['error_message'] = 'Ce nom d\'utilisateur ou email est déjà utilisé.';
    } else {
        $stmt = $pdo->prepare("UPDATE tourists SET username = ?, email = ?, full_name = ?, phone = ?, country = ?, points = ? WHERE id = ?");
        if ($stmt->execute([$username, $email, $full_name, $phone, $country, $points, $tourist_id])) {
            $_SESSION['success_message'] = 'Touriste mis à jour avec succès !';
            redirect('tourists.php');
        } else {
            $_SESSION['error_message'] = 'Erreur lors de la mise à jour. Veuillez réessayer.';
        }
    }
}
?>

<?php include 'admin_header.php'; ?>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-1">Modifier un touriste</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item"><a href="dashboard.php">Tableau de bord</a></li>
                    <li class="breadcrumb-item"><a href="tourists.php">Touristes</a></li>
                    <li class="breadcrumb-item active">Modifier</li>
                </ol>
            </nav>
        </div>
        <a href="tourists.php" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0">
            <h5 class="mb-0">Informations du touriste</h5>
        </div>
        <div class="card-body">
            <form method="POST" class="needs-validation" novalidate>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="username" class="form-label">Nom d'utilisateur *</label>
                            <input type="text" class="form-control" id="username" name="username" 
                                   value="<?php echo htmlspecialchars($tourist['username']); ?>" required>
                            <div class="invalid-feedback">
                                Veuillez saisir un nom d'utilisateur valide.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo htmlspecialchars($tourist['email']); ?>" required>
                            <div class="invalid-feedback">
                                Veuillez saisir un email valide.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Nom complet *</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" 
                                   value="<?php echo htmlspecialchars($tourist['full_name']); ?>" required>
                            <div class="invalid-feedback">
                                Veuillez saisir le nom complet.
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="phone" class="form-label">Téléphone</label>
                            <input type="tel" class="form-control" id="phone" name="phone" 
                                   value="<?php echo htmlspecialchars($tourist['phone']); ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="country" class="form-label">Pays</label>
                            <input type="text" class="form-control" id="country" name="country" 
                                   value="<?php echo htmlspecialchars($tourist['country']); ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="points" class="form-label">Points *</label>
                            <input type="number" class="form-control" id="points" name="points" 
                                   value="<?php echo $tourist['points']; ?>" required>
                            <div class="invalid-feedback">
                                Veuillez saisir un nombre de points valide.
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 mt-4">
                        <div class="d-flex justify-content-end gap-3">
                            <a href="tourists.php" class="btn btn-outline-secondary">
                                Annuler
                            </a>
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

<script>
// Form validation
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.needs-validation');
    
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');
        }, false);
    });
});
</script>

<?php include 'admin_footer.php'; ?>