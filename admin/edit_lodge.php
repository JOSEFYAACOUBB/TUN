<?php
require_once '../includes/config.php';

if (!is_logged_in() || !is_admin()) {
    redirect('login.php');
}

if (!isset($_GET['id'])) {
    redirect('lodges.php');
}

$lodge_id = (int)$_GET['id'];
$lodge = get_lodge_by_id($lodge_id);

if (!$lodge) {
    redirect('lodges.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $location = trim($_POST['location']);
    $description = trim($_POST['description']);
    $price_per_night = (float)$_POST['price_per_night'];
    $capacity = (int)$_POST['capacity'];
    $sustainability_score = (int)$_POST['sustainability_score'];

    // Handle image upload if new image was provided
    $image_url = $lodge['image_url']; // Keep existing by default
    
    if (!empty($_FILES['lodge_images']['name'][0])) {
        require_once '../includes/image_upload.php';
    
        if (!empty($uploaded_images)) {
            $image_url = json_encode($uploaded_images);
        }
    }

    $stmt = $pdo->prepare("UPDATE eco_lodges SET name = ?, location = ?, description = ?, price_per_night = ?, capacity = ?, sustainability_score = ?, image_url = ? WHERE id = ?");
    if ($stmt->execute([$name, $location, $description, $price_per_night, $capacity, $sustainability_score, $image_url, $lodge_id])) {
        $_SESSION['success_message'] = 'Éco-lodge mis à jour avec succès !';
        redirect('lodges.php');
    } else {
        $_SESSION['error_message'] = 'Erreur lors de la mise à jour. Veuillez réessayer.';
    }
}
?>

<?php include 'admin_header.php'; ?>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-1">Modifier un éco-lodge</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item"><a href="dashboard.php">Tableau de bord</a></li>
                    <li class="breadcrumb-item"><a href="lodges.php">Éco-lodges</a></li>
                    <li class="breadcrumb-item active">Modifier</li>
                </ol>
            </nav>
        </div>
        <a href="lodges.php" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0">
            <h5 class="mb-0">Informations de l'éco-lodge</h5>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom *</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="<?php echo htmlspecialchars($lodge['name']); ?>" required>
                            <div class="invalid-feedback">
                                Veuillez saisir un nom valide.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="location" class="form-label">Localisation *</label>
                            <input type="text" class="form-control" id="location" name="location" 
                                   value="<?php echo htmlspecialchars($lodge['location']); ?>" required>
                            <div class="invalid-feedback">
                                Veuillez saisir une localisation.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description *</label>
                            <textarea class="form-control" id="description" name="description" rows="5" required><?php echo htmlspecialchars($lodge['description']); ?></textarea>
                            <div class="invalid-feedback">
                                Veuillez saisir une description.
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="price_per_night" class="form-label">Prix par nuit (DT) *</label>
                            <div class="input-group">
                                <input type="number" step="0.01" class="form-control" id="price_per_night" name="price_per_night" 
                                       value="<?php echo $lodge['price_per_night']; ?>" required>
                                <span class="input-group-text">DT</span>
                            </div>
                            <div class="invalid-feedback">
                                Veuillez saisir un prix valide.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="capacity" class="form-label">Capacité *</label>
                            <input type="number" class="form-control" id="capacity" name="capacity" 
                                   value="<?php echo $lodge['capacity']; ?>" required>
                            <div class="invalid-feedback">
                                Veuillez saisir une capacité valide.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="sustainability_score" class="form-label">Score de durabilité *</label>
                            <div class="d-flex align-items-center gap-3">
                                <input type="number" class="form-control" id="sustainability_score" name="sustainability_score" 
                                       min="0" max="100" value="<?php echo $lodge['sustainability_score']; ?>" required>
                                <span class="text-muted">%</span>
                            </div>
                            <div class="invalid-feedback">
                                Veuillez saisir un score entre 0 et 100.
                            </div>
                        </div>
                        
                        <!-- Image Upload Section -->
                    </div>
                    
                    <div class="col-12 mt-4">
                        <div class="d-flex justify-content-end gap-3">
                            <a href="lodges.php" class="btn btn-outline-secondary">
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

<!-- Include CSS -->
<link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/upload.css">

<!-- Include JavaScript -->
<script src="<?php echo SITE_URL; ?>/assets/js/upload.js"></script>

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

    // Sync range and number inputs for sustainability score
    const rangeInput = document.getElementById('sustainability_score_range');
    const numberInput = document.getElementById('sustainability_score');
    
    rangeInput.addEventListener('input', function() {
        numberInput.value = this.value;
    });
    
    numberInput.addEventListener('input', function() {
        rangeInput.value = this.value;
    });

    // Handle image removal
    document.querySelectorAll('.remove-image').forEach(btn => {
        btn.addEventListener('click', function() {
            const imagePath = this.getAttribute('data-image');
            if (confirm('Supprimer cette image ?')) {
                // Here you would typically make an AJAX call to delete the image from server
                this.parentElement.remove();
                // Add hidden input to track deleted images if needed
            }
        });
    });
});
</script>

<?php include 'admin_footer.php'; ?>