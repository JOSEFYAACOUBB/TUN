<?php
require_once '../includes/config.php';

if (is_logged_in()) {
    redirect(is_admin() ? 'dashboard.php' : '../tourist/dashboard.php');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_utilisateur = trim($_POST['nom_utilisateur']);
    $mot_de_passe = trim($_POST['mot_de_passe']);
    
    if (login_admin($nom_utilisateur, $mot_de_passe)) {
        $_SESSION['success_message'] = 'Bienvenue, ' . $nom_utilisateur . ' !';
        redirect('dashboard.php');
    } else {
        $error = 'Nom d\'utilisateur ou mot de passe incorrect';
    }
}
?>

<?php include '../includes/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="card-title text-center mb-4">Connexion Admin</h2>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <div class="mb-3">
                            <label for="nom_utilisateur" class="form-label">Nom d'utilisateur</label>
                            <input type="text" class="form-control" id="nom_utilisateur" name="nom_utilisateur" required>
                        </div>
                        <div class="mb-3">
                            <label for="mot_de_passe" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">Se connecter</button>
                        </div>
                    </form>
                    
                    <div class="text-center mt-3">
                        <a href="../index.php">Retour à l'accueil</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>