<?php
require_once 'includes/config.php';
require_once 'includes/header.php';

$activities = get_activities();
?>

<section class="eco-activities-section">
    <div class="container">
        <div class="section-header text-center mb-5">
            <span class="section-subtitle">Découvrez nos</span>
            <h1 class="section-title">Activités Écologiques</h1>
            <p class="section-description">Des expériences uniques en harmonie avec la nature tunisienne</p>
        </div>
        
        <div class="row g-4">
            <?php foreach ($activities as $activity): ?>
                <div class="col-lg-6" id="activity-<?= $activity['id'] ?>">
                    <div class="eco-activity-card">
                        <div class="row g-0">
                            <div class="col-md-5 activity-image-container">
                                <img src="<?= $activity['image_url'] ?>" 
                                     class="activity-image" 
                                     alt="<?= htmlspecialchars($activity['name']) ?>"
                                     loading="lazy">
                                <div class="duration-badge">
                                    <i class="far fa-clock"></i> <?= $activity['duration'] ?>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="activity-details">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h3><?= htmlspecialchars($activity['name']) ?></h3>
                                        <div class="points-badge">
                                            +<?= $activity['points_reward'] ?> pts
                                        </div>
                                    </div>
                                    
                                    <div class="location">
                                        <i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($activity['location']) ?>
                                    </div>
                                    
                                    <p class="description"><?= substr(htmlspecialchars($activity['description']), 0, 120) ?>...</p>
                                    
                                    <div class="activity-footer">
                                        <div class="price">
                                            <?= number_format($activity['price'] ) ?> DT
                                        </div>
                                        
                                        <div class="action-buttons">
                                            <button class="btn-view-details" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#activityModal<?= $activity['id'] ?>">
                                                Détails
                                            </button>
                                            
                                            <?php if (is_logged_in() && is_tourist()): ?>
                                                <a href="tourist/bookings.php?activity_id=<?= $activity['id'] ?>" class="btn-book-now">
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
                </div>

                <!-- Activity Modal -->
                <div class="modal fade" id="activityModal<?= $activity['id'] ?>" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><?= htmlspecialchars($activity['name']) ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="modal-image-container">
                                            <img src="<?= $activity['image_url'] ?>" 
                                                 class="img-fluid rounded" 
                                                 alt="<?= htmlspecialchars($activity['name']) ?>">
                                        </div>
                                        <div class="facts-box mt-3">
                                            <div class="fact-item">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <span><?= htmlspecialchars($activity['location']) ?></span>
                                            </div>
                                            <div class="fact-item">
                                                <i class="fas fa-money-bill-wave"></i>
                                                <span><?= number_format($activity['price']) ?> DT</span>
                                            </div>
                                            <div class="fact-item">
                                                <i class="far fa-clock"></i>
                                                <span><?= $activity['duration'] ?></span>
                                            </div>
                                            <div class="fact-item">
                                                <i class="fas fa-gift"></i>
                                                <span>+<?= $activity['points_reward'] ?> points</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="modal-description">
                                            <h6>Description</h6>
                                            <p><?= htmlspecialchars($activity['description']) ?></p>
                                            
                                            <h6>Ce qui est inclus</h6>
                                            <ul class="included-features">
                                                <li><i class="fas fa-user-tie"></i> Guide professionnel</li>
                                                <li><i class="fas fa-tools"></i> Équipement fourni</li>
                                                <li><i class="fas fa-utensils"></i> Collations locales</li>
                                                <li><i class="fas fa-bus"></i> Transport (si précisé)</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                <?php if (is_logged_in() && is_tourist()): ?>
                                    <a href="tourist/bookings.php?activity_id=<?= $activity['id'] ?>" class="btn btn-primary">
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