
<?php
require_once 'includes/config.php';
require_once 'includes/header.php';

$lodges = get_eco_lodges(3);
$activities = get_activities(3);
?>

<!-- Hero Section -->
<section class="hero-section bg-primary text-white py-5">
    <div class="container-fluid px-3 px-md-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-3">Découvrez la Tunisie Durable</h1>
                <p class="lead mb-4">Vivez un voyage écologique tout en soutenant les communautés locales et en préservant la nature</p>
                <div class="d-flex flex-wrap gap-3">
                    <?php if (!is_logged_in()): ?>
                        <a href="tourist/register.php" class="btn btn-light btn-lg px-4">Rejoignez-nous</a>
                        <a href="activities.php" class="btn btn-outline-light btn-lg px-4">Nos Activités</a>
                    <?php else: ?>
                        <a href="lodges.php" class="btn btn-light btn-lg px-4">Réserver un Lodge</a>
                        <a href="activities.php" class="btn btn-outline-light btn-lg px-4">Trouver des Activités</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="assets/images/background.jpg" alt="Paysage Tunisien" class="img-fluid rounded-3 shadow">
            </div>
        </div>
    </div>
</section>

<!-- Featured Eco-Lodges -->
<section class="py-5">
    <div class="container-fluid px-3 px-md-5">
        <div class="text-center mb-5">
            <span class="text-uppercase text-primary fw-bold d-block mb-2">Hébergements Premium</span>
            <h2 class="fw-bold mb-3">Eco-Lodges en Vedette</h2>
            <p class="text-muted mx-auto" style="max-width: 700px;">Des hébergements durables sélectionnés pour le voyageur conscient</p>
        </div>
        
        <div class="row g-4">
            <?php foreach ($lodges as $lodge): ?> 
                <div class="col-xl-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm lodge-card">
                        <div class="position-relative">
                            <img src="<?= $lodge['image_url'] ?>" class="card-img-top lodge-img" alt="<?= $lodge['name'] ?>">
                            <span class="position-absolute top-0 end-0 m-3 bg-success text-white px-3 py-1 rounded-pill">
                                <?= $lodge['sustainability_score'] ?>% Durable
                            </span>
                        </div>
                        <div class="card-body"> 
                            <h3 class="card-title h5"><?= $lodge['name'] ?></h3>
                            <p class="text-muted mb-2">
                                <i class="fas fa-map-marker-alt text-primary me-1"></i> <?= $lodge['location'] ?>
                            </p>
                            <p class="card-text mb-3"><?= substr($lodge['description'], 0, 100) ?>...</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 d-flex justify-content-between align-items-center">
                            <span class="text-primary fw-bold"><?= number_format($lodge['price_per_night'] ) ?> DT/nuit</span>
                            <a href="lodges.php#lodge-<?= $lodge['id'] ?>" class="btn btn-sm btn-outline-primary">Voir Détails</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-4">
            <a href="lodges.php" class="btn btn-outline-primary px-4">Voir Tous les Lodges</a>
        </div>
    </div>
</section>

<!-- Featured Activities -->
<section class="py-5 bg-light">
    <div class="container-fluid px-3 px-md-5">
        <div class="text-center mb-5">
            <span class="text-uppercase text-primary fw-bold d-block mb-2">Expériences Uniques</span>
            <h2 class="fw-bold mb-3">Activités en Vedette</h2>
            <p class="text-muted mx-auto" style="max-width: 700px;">Plongez dans la culture tunisienne authentique et la nature</p>
        </div>
        
        <div class="row g-4">
            <?php foreach ($activities as $activity): ?>
                <div class="col-xl-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="position-relative">
                            <img src="<?= $activity['image_url'] ?>" class="card-img-top activity-img" alt="<?= $activity['name'] ?>">
                            <span class="position-absolute bottom-0 start-0 m-3 bg-primary text-white px-3 py-1 rounded-pill">
                                <?= $activity['duration'] ?>
                            </span>
                        </div>
                        <div class="card-body">
                            <h3 class="card-title h5"><?= $activity['name'] ?></h3>
                            <p class="text-muted mb-2">
                                <i class="fas fa-map-marker-alt text-primary me-1"></i> <?= $activity['location'] ?>
                            </p>
                            <p class="card-text mb-3"><?= substr($activity['description'], 0, 100) ?>...</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-primary fw-bold"><?= number_format($activity['price'] ) ?> DT</span>
                                <span class="badge bg-warning text-dark ms-2">+<?= $activity['points_reward'] ?> pts</span>
                            </div>
                            <a href="activities.php#activity-<?= $activity['id'] ?>" class="btn btn-sm btn-outline-primary">Détails</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-4">
            <a href="activities.php" class="btn btn-outline-primary px-4">Voir Toutes les Activités</a>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-5">
    <div class="container-fluid px-3 px-md-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-5">
                <span class="text-uppercase text-primary fw-bold d-block mb-2">Notre Différence</span>
                <h2 class="fw-bold mb-3">Pourquoi Choisir Tunisia Eco-Travel?</h2>
                <p class="lead mb-4">Nous combinons voyage de luxe et durabilité pour créer des expériences inoubliables qui redonnent à la communauté.</p>
                <a href="about.php" class="btn btn-primary px-4">En Savoir Plus</a>
            </div>
            <div class="col-lg-7">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="p-4 bg-white rounded-3 shadow-sm h-100">
                            <div class="icon-square bg-primary bg-opacity-10 text-primary rounded-3 mb-3">
                                <i class="fas fa-leaf fa-2x"></i>
                            </div>
                            <h4 class="h5 mb-3">Tourisme Durable</h4>
                            <p class="mb-0">Nos initiatives neutres en carbone garantissent que vos voyages ne laissent que des empreintes positives.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-4 bg-white rounded-3 shadow-sm h-100">
                            <div class="icon-square bg-primary bg-opacity-10 text-primary rounded-3 mb-3">
                                <i class="fas fa-hands-helping fa-2x"></i>
                            </div>
                            <h4 class="h5 mb-3">Impact Local</h4>
                            <p class="mb-0">85% de nos revenus vont directement aux communautés locales et aux efforts de conservation.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-4 bg-white rounded-3 shadow-sm h-100">
                            <div class="icon-square bg-primary bg-opacity-10 text-primary rounded-3 mb-3">
                                <i class="fas fa-gift fa-2x"></i>
                            </div>
                            <h4 class="h5 mb-3">Programme de Récompenses</h4>
                            <p class="mb-0">Gagnez des points pour chaque choix durable et échangez-les contre des expériences exclusives.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-4 bg-white rounded-3 shadow-sm h-100">
                            <div class="icon-square bg-primary bg-opacity-10 text-primary rounded-3 mb-3">
                                <i class="fas fa-headset fa-2x"></i>
                            </div>
                            <h4 class="h5 mb-3">Conciergerie 24/7</h4>
                            <p class="mb-0">Nos experts en voyage sont disponibles 24h/24 pour personnaliser votre séjour.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-5 bg-primary text-white">
    <div class="container-fluid px-3 px-md-5">
        <div class="text-center mb-5">
            <span class="text-uppercase text-white-50 fw-bold d-block mb-2">Témoignages</span>
            <h2 class="fw-bold mb-3">Ce Que Disent Nos Clients</h2>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="p-4 bg-white bg-opacity-10 rounded-3 h-100">
                    <div class="mb-3">
                        <i class="fas fa-quote-left text-white-50 me-2"></i>
                        <p class="mb-0">L'éco-lodge était magnifique et le personnel a fait tout son possible pour rendre notre séjour mémorable tout en respectant l'environnement.</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <img src="assets/images/temoignage/salah.jpg" class="rounded-circle me-3" width="50" height="50" alt="Sarah M.">
                        <div>
                            <h5 class="h6 mb-0">Sarah M.</h5>
                            <small class="text-white-50">Egypt, Cairo</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-white bg-opacity-10 rounded-3 h-100">
                    <div class="mb-3">
                        <i class="fas fa-quote-left text-white-50 me-2"></i>
                        <p class="mb-0">Le safari dans le désert avec des guides locaux était le point fort de notre voyage. Leur connaissance de l'écosystème était impressionnante.</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <img src="assets/images/temoignage/james.jpg" class="rounded-circle me-3" width="50" height="50" alt="James L.">
                        <div>
                            <h5 class="h6 mb-0">James L.</h5>
                            <small class="text-white-50">Toronto, Canada</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-white bg-opacity-10 rounded-3 h-100">
                    <div class="mb-3">
                        <i class="fas fa-quote-left text-white-50 me-2"></i>
                        <p class="mb-4">Réserver via Tunisia Eco-Travel m'a fait me sentir bien pendant mes vacances en sachant que je soutenais les communautés locales.</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <img src="assets/images/temoignage/amina.jpg" class="rounded-circle me-3" width="50" height="50" alt="Amina K.">
                        <div>
                            <h5 class="h6 mb-0">Amina K.</h5>
                            <small class="text-white-50">Dubai, UAE</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>