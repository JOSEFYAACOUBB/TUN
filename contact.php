<?php
require_once 'includes/config.php';
require_once 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Traitement du formulaire de contact (simulé)
    $_SESSION['success_message'] = 'Merci pour votre message ! Nous vous répondrons bientôt.';
    redirect('contact.php');
}
?>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h1 class="mb-4">Contactez-nous</h1>
                <p class="lead">Des questions ou des commentaires ? Nous serions ravis d'avoir de vos nouvelles !</p>
                
                <form method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Votre Nom</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Sujet</label>
                        <select class="form-select" id="subject" name="subject" required>
                            <option value="" selected disabled>Sélectionnez un sujet</option>
                            <option value="booking">Demande de réservation</option>
                            <option value="feedback">Commentaire</option>
                            <option value="partnership">Partenariat</option>
                            <option value="other">Autre</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Envoyer le message</button>
                </form>
            </div>
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Nos Coordonnées</h4>
                        <div class="mb-4">
                            <h5><i class="fas fa-map-marker-alt text-primary me-2"></i> Adresse</h5>
                            <p>123 Rue de l'Éco-Tourisme<br>Tunis 1000, Tunisie</p>
                        </div>
                        <div class="mb-4">
                            <h5><i class="fas fa-phone text-primary me-2"></i> Téléphone</h5>
                            <p>+216 12 345 678</p>
                        </div>
                        <div class="mb-4">
                            <h5><i class="fas fa-envelope text-primary me-2"></i> Email</h5>
                            <p>info@tunisiaecotravel.com</p>
                        </div>
                        <div class="mb-4">
                            <h5><i class="fas fa-clock text-primary me-2"></i> Heures d'ouverture</h5>
                            <p>Lundi - Vendredi : 9h00 - 17h00<br>Samedi : 10h00 - 14h00</p>
                        </div>
                        <div class="mt-4">
                            <h5>Suivez-nous</h5>
                            <div class="social-links">
                                <a href="#" class="btn btn-outline-primary btn-sm me-2"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class="btn btn-outline-primary btn-sm me-2"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="btn btn-outline-primary btn-sm me-2"><i class="fab fa-instagram"></i></a>
                                <a href="#" class="btn btn-outline-primary btn-sm me-2"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>