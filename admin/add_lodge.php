<?php
require_once '../includes/config.php';

if (!is_logged_in() || !is_admin()) {
    redirect('login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input
    $name = trim($_POST['name']);
    $location = trim($_POST['location']);
    $description = trim($_POST['description']);
    $price_per_night = (float)$_POST['price_per_night'];
    $capacity = (int)$_POST['capacity'];
    $sustainability_score = (int)$_POST['sustainability_score'];

    // Process file uploads
    $imagePaths = [];
    if (!empty($_FILES['photos']['name'][0])) {
        $uploadDir = '../assets/images/lodges/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        foreach ($_FILES['photos']['tmp_name'] as $index => $tmpName) {
            // Security checks
            $fileType = $_FILES['photos']['type'][$index];
            $fileSize = $_FILES['photos']['size'][$index];
            $error = $_FILES['photos']['error'][$index];

            // Skip if error occurred
            if ($error !== UPLOAD_ERR_OK) {
                continue;
            }

            // Validate file type and size
            $allowedTypes = ['image/jpeg', 'image/png'];
            if (!in_array($fileType, $allowedTypes) || $fileSize > 5 * 1024 * 1024) {
                continue;
            }

            // Generate unique filename
            $ext = pathinfo($_FILES['photos']['name'][$index], PATHINFO_EXTENSION);
            $newFileName = 'lodge_' . uniqid() . '.' . strtolower($ext);
            $destination = $uploadDir . $newFileName;

            // Move file if valid
            if (move_uploaded_file($tmpName, $destination)) {
                $imagePaths[] = 'assets/images/lodges/' . $newFileName;
            }
        }
    }

    // Save to database
    $image_url = !empty($imagePaths) ? json_encode($imagePaths) : null;
    
    $stmt = $pdo->prepare("INSERT INTO eco_lodges (name, location, description, price_per_night, capacity, sustainability_score, image_url) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if ($stmt->execute([$name, $location, $description, $price_per_night, $capacity, $sustainability_score, $image_url])) {
        $_SESSION['success_message'] = 'Éco-lodge ajouté avec succès !';
        redirect('lodges.php');
    } else {
        $_SESSION['error_message'] = 'Erreur lors de l\'ajout de l\'éco-lodge.';
    }
}
?>

<?php include 'admin_header.php'; ?>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-1">Ajouter un éco-lodge</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item"><a href="dashboard.php">Tableau de bord</a></li>
                    <li class="breadcrumb-item"><a href="lodges.php">Éco-lodges</a></li>
                    <li class="breadcrumb-item active">Nouveau</li>
                </ol>
            </nav>
        </div>
        <a href="lodges.php" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0">
            <h5 class="mb-0">Détails de l'éco-lodge</h5>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom *</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            <div class="invalid-feedback">
                                Veuillez saisir un nom valide.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="location" class="form-label">Localisation *</label>
                            <input type="text" class="form-control" id="location" name="location" required>
                            <div class="invalid-feedback">
                                Veuillez saisir une localisation.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description *</label>
                            <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
                            <div class="invalid-feedback">
                                Veuillez saisir une description.
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="price_per_night" class="form-label">Prix par nuit (DT) *</label>
                            <div class="input-group">
                                <input type="number" step="0.01" class="form-control" id="price_per_night" name="price_per_night" required>
                                <span class="input-group-text">DT</span>
                            </div>
                            <div class="invalid-feedback">
                                Veuillez saisir un prix valide.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="capacity" class="form-label">Capacité *</label>
                            <input type="number" class="form-control" id="capacity" name="capacity" required>
                            <div class="invalid-feedback">
                                Veuillez saisir une capacité valide.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="sustainability_score" class="form-label">Score de durabilité *</label>
                            <div class="d-flex align-items-center gap-3">
                                <input type="number" class="form-control" id="sustainability_score" name="sustainability_score" min="0" max="100" required>
                                <span class="text-muted">%</span>
                            </div>
                            <div class="invalid-feedback">
                                Veuillez saisir un score entre 0 et 100.
                            </div>
                        </div>
                        
                        <!-- Image Upload Section -->
                        <div class="mb-4">
                            <label class="form-label">Photos du lodge</label>
                            <div id="drop-zone" class="border-2 border-dashed rounded-3 p-5 text-center cursor-pointer bg-light">
                                <input type="file" id="file-input" name="photos[]" multiple accept="image/jpeg,image/png" class="d-none">
                                <div class="py-3">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                    <p class="mb-1">Glissez-déposez vos images ici</p>
                                    <p class="text-muted small mb-0">ou <span class="text-primary fw-bold">cliquez pour parcourir</span></p>
                                    <p class="text-muted small mt-2">Formats supportés: JPG, PNG (Max 5MB)</p>
                                </div>
                            </div>
                            <div id="preview-container" class="mt-4 d-flex flex-wrap gap-3"></div>
                        </div>
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

    // Set initial value
    rangeInput.dispatchEvent(new Event('input'));
});
</script>

<?php include 'admin_footer.php'; ?>