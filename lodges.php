<?php
require_once 'includes/config.php';
require_once 'includes/header.php';

$lodges = get_eco_lodges();
?>

<section class="eco-lodges-section">
    <div class="container">
        <div class="section-header text-center mb-5">
            <span class="section-subtitle">Découvrez nos</span>
            <h1 class="section-title">Éco-Lodges Exceptionnels</h1>
            <p class="section-description">Vivez une expérience unique en harmonie avec la nature</p>
        </div>
        
        <div class="row g-4">
            <?php foreach ($lodges as $lodge): ?>
                <div class="col-lg-6" id="lodge-<?= $lodge['id'] ?>">
                    <div class="eco-lodge-card">
                        <div class="row g-0">
                            <div class="col-md-5 lodge-image-container">
                                <img src="<?= $lodge['image_url'] ?>" 
                                     class="lodge-image" 
                                     alt="<?= htmlspecialchars($lodge['name']) ?>"
                                     loading="lazy">
                                <div class="sustainability-badge">
                                    durabilité score <?= $lodge['sustainability_score'] ?>%
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="lodge-details">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h3><?= htmlspecialchars($lodge['name']) ?></h3>
                                        <div class="price-tag">
                                            <?= number_format($lodge['price_per_night']) ?> <small>DT/nuit</small>
                                        </div>
                                    </div>
                                    
                                    <div class="location">
                                        <i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($lodge['location']) ?>
                                    </div>
                                    
                                    <p class="description"><?= substr(htmlspecialchars($lodge['description']), 0, 120) ?>...</p>
                                    
                                    <div class="lodge-footer">
                                        <button class="btn-view-details" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#lodgeModal<?= $lodge['id'] ?>">
                                            Voir détails
                                        </button>
                                        
                                        <?php if (is_logged_in() && is_tourist()): ?>
                                            <a href="tourist/bookings.php?lodge_id=<?= $lodge['id'] ?>" class="btn-book-now">
                                                Réserver
                                            </a>
                                        <?php elseif (!is_logged_in()): ?>
                                            <a href="tourist/login.php" class="btn-book-now">
                                                Connexion
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lodge Modal -->
                <div class="modal fade" id="lodgeModal<?= $lodge['id'] ?>" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><?= htmlspecialchars($lodge['name']) ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="modal-image-container">
                                            <img src="<?= $lodge['image_url'] ?>" 
                                                 class="img-fluid rounded" 
                                                 alt="<?= htmlspecialchars($lodge['name']) ?>">
                                        </div>
                                        <div class="facts-box mt-3">
                                            <div class="fact-item">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <span><?= htmlspecialchars($lodge['location']) ?></span>
                                            </div>
                                            <div class="fact-item">
                                                <i class="fas fa-money-bill-wave"></i>
                                                <span><?= number_format($lodge['price_per_night']) ?> DT/nuit</span>
                                            </div>
                                            <div class="fact-item">
                                                <i class="fas fa-users"></i>
                                                <span><?= $lodge['capacity'] ?> personnes</span>
                                            </div>
                                            <div class="fact-item">
                                                <i class="fas fa-leaf"></i>
                                                <span><?= $lodge['sustainability_score'] ?>% durable</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="modal-description">
                                            <h6>Description</h6>
                                            <p><?= htmlspecialchars($lodge['description']) ?></p>
                                            
                                            <h6>Caractéristiques écologiques</h6>
                                            <ul class="eco-features">
                                                <li><i class="fas fa-solar-panel"></i> Énergie solaire</li>
                                                <li><i class="fas fa-tint"></i> Gestion de l'eau</li>
                                                <li><i class="fas fa-utensils"></i> Nourriture locale</li>
                                                <li><i class="fas fa-recycle"></i> Recyclage complet</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                <?php if (is_logged_in() && is_tourist()): ?>
                                    <a href="tourist/bookings.php?lodge_id=<?= $lodge['id'] ?>" class="btn btn-primary">
                                        Réserver maintenant
                                    </a>
                                <?php elseif (!is_logged_in()): ?>
                                    <a href="tourist/login.php" class="btn btn-primary">
                                        Se connecter pour réserver
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>