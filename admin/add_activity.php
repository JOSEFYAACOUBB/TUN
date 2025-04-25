<?php
require_once '../includes/config.php';

if (!is_logged_in() || !is_admin()) {
    redirect('login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = trim($_POST['name']);
    $location = trim($_POST['location']);
    $description = trim($_POST['description']);
    $price = (float)$_POST['price'];
    $duration = trim($_POST['duration']);
    $points_reward = (int)$_POST['points_reward'];

    // Process file uploads
    $uploaded_images = [];
    if (!empty($_FILES['activity_images']['name'][0])) {
        $uploadDir = '../assets/images/activities/';
        
        // Create directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Process each uploaded file
        foreach ($_FILES['activity_images']['tmp_name'] as $key => $tmpName) {
            // Security checks
            $fileType = $_FILES['activity_images']['type'][$key];
            $fileSize = $_FILES['activity_images']['size'][$key];
            $error = $_FILES['activity_images']['error'][$key];

            // Skip if error occurred
            if ($error !== UPLOAD_ERR_OK) {
                continue;
            }

            // Validate file type
            $allowedTypes = ['image/jpeg', 'image/png'];
            if (!in_array($fileType, $allowedTypes)) {
                continue;
            }

            // Validate file size (5MB max)
            if ($fileSize > 5 * 1024 * 1024) {
                continue;
            }

            // Generate unique filename
            $ext = pathinfo($_FILES['activity_images']['name'][$key], PATHINFO_EXTENSION);
            $newFilename = 'activity_' . uniqid() . '.' . strtolower($ext);
            $destination = $uploadDir . $newFilename;

            // Move file if valid
            if (move_uploaded_file($tmpName, $destination)) {
                $uploaded_images[] = 'assets/images/activities/' . $newFilename;
            }
        }
    }

    // Save to database
    $image_urls = !empty($uploaded_images) ? json_encode($uploaded_images) : null;
    
    $stmt = $pdo->prepare("INSERT INTO activities (name, location, description, price, duration, points_reward, image_url) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    if ($stmt->execute([$name, $location, $description, $price, $duration, $points_reward, $image_urls])) {
        $_SESSION['success_message'] = 'Activité ajoutée avec succès !';
        redirect('activities.php');
    } else {
        $_SESSION['error_message'] = 'Erreur lors de l\'ajout de l\'activité.';
    }
}
?>

<?php include 'admin_header.php'; ?>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-1">Ajouter une nouvelle activité</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item"><a href="dashboard.php">Tableau de bord</a></li>
                    <li class="breadcrumb-item"><a href="activities.php">Activités</a></li>
                    <li class="breadcrumb-item active">Nouvelle activité</li>
                </ol>
            </nav>
        </div>
        <a href="activities.php" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0">
            <h5 class="mb-0">Détails de l'activité</h5>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nom de l'activité *</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        <div class="invalid-feedback">
                            Veuillez saisir un nom valide.
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="location" class="form-label">Localisation *</label>
                        <input type="text" class="form-control" id="location" name="location" required>
                        <div class="invalid-feedback">
                            Veuillez saisir une localisation.
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <label for="description" class="form-label">Description *</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                        <div class="invalid-feedback">
                            Veuillez saisir une description.
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <label for="price" class="form-label">Prix (DT) *</label>
                        <div class="input-group">
                            <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                            <span class="input-group-text">DT</span>
                        </div>
                        <div class="invalid-feedback">
                            Veuillez saisir un prix valide.
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <label for="duration" class="form-label">Durée *</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="duration" name="duration" placeholder="Ex: 2h30" required>
                            <span class="input-group-text">heures</span>
                        </div>
                        <div class="invalid-feedback">
                            Veuillez saisir une durée.
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <label for="points_reward" class="form-label">Points offerts *</label>
                        <input type="number" class="form-control" id="points_reward" name="points_reward" required>
                        <div class="invalid-feedback">
                            Veuillez saisir un nombre de points.
                        </div>
                    </div>
                    
                    <!-- Image Upload Section -->
                    <div class="col-12 mt-4">
                        <label class="form-label">Images de l'activité</label>
                        <div id="drop-zone" class="border-2 border-dashed rounded-3 p-5 text-center cursor-pointer bg-light">
                            <input type="file" id="file-input" name="activity_images[]" multiple accept="image/jpeg,image/png" class="d-none">
                            <div class="py-3">
                                <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                <p class="mb-1">Glissez-déposez vos images ici</p>
                                <p class="text-muted small mb-0">ou <span class="text-primary fw-bold">cliquez pour parcourir</span></p>
                                <p class="text-muted small mt-2">Formats supportés: JPG, PNG (Max 5MB)</p>
                            </div>
                        </div>
                        <div id="preview-container" class="mt-4 d-flex flex-wrap gap-3"></div>
                    </div>
                    
                    <div class="col-12 mt-4">
                        <div class="d-flex justify-content-end gap-3">
                            <a href="activities.php" class="btn btn-outline-secondary">
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
});
</script>

<?php include 'admin_footer.php'; ?>