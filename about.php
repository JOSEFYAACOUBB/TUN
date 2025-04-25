<?php
require_once 'includes/config.php';
require_once 'includes/header.php';
?>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h1 class="mb-4">À propos de Tunisia Eco-Travel</h1>
                <p class="lead">Promouvoir un tourisme durable en Tunisie tout en soutenant les communautés locales et en préservant les ressources naturelles.</p>
                
                <h4 class="mt-5">Notre Mission</h4>
                <p>Nous visons à transformer le tourisme en Tunisie en proposant des expériences de voyage écologiques qui profitent à la fois aux visiteurs et aux communautés locales. Notre plateforme connecte les voyageurs responsables avec des hébergements durables et des activités authentiques qui mettent en valeur le riche patrimoine culturel et la beauté naturelle de la Tunisie.</p>
                
                <h4 class="mt-4">Nos Valeurs</h4>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Responsabilité environnementale</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Soutien aux communautés locales</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Préservation culturelle</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Expériences de voyage authentiques</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Transparence et responsabilité</li>
                </ul>
            </div>
            <div class="col-lg-6">
                <img src="assets/images/team/about.png" class="img-fluid rounded" alt="Culture Tunisienne">
                
                <h4 class="mt-5">Comment Nous Travaillons</h4>
                <div class="accordion" id="howWeWorkAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Sélection des Partenaires
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#howWeWorkAccordion">
                            <div class="accordion-body">
                                Nous évaluons soigneusement tous nos partenaires pour nous assurer qu'ils répondent à nos critères de durabilité. Chaque éco-gîte et prestataire d'activités doit démontrer un engagement réel envers la protection de l'environnement et le soutien à la communauté.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Mesure d'Impact
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#howWeWorkAccordion">
                            <div class="accordion-body">
                                Nous suivons l'impact positif de chaque réservation, y compris la réduction de l'empreinte carbone, les emplois locaux créés et les projets communautaires soutenus. Ces données sont partagées avec nos voyageurs pour montrer la différence qu'ils font.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Système de Récompenses
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#howWeWorkAccordion">
                            <div class="accordion-body">
                                Notre système de points récompense les voyageurs pour leurs choix durables. Les points peuvent être échangés contre des réductions, des nuits gratuites ou des dons à des projets de conservation locaux.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-5">
            <div class="col-12">
                <h2 class="text-center mb-4">Rencontrez Notre Équipe</h2>
                <div class="row text-center">
                    <div class="col-md-4 mb-4">
                        <div class="team-member p-4">
                            <img src="assets/images/team/youssef.jpg" class="rounded-circle mb-3" width="150" height="150" alt="Membre de l'équipe">
                            <h4>Youssef Ben Yaacoub</h4>
                            <p class="text-muted">Fondateur & PDG</p>
                            <p>Passionné par le tourisme durable et le patrimoine tunisien.</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="team-member p-4">
                            <img src="assets/images/team/elyes.jpg" class="rounded-circle mb-3" width="150" height="150" alt="Membre de l'équipe">
                            <h4>Elyes Attafi</h4>
                            <p class="text-muted">Responsable Communauté</p>
                            <p>Connecte avec les communautés locales pour développer des expériences authentiques.</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="team-member p-4">
                            <img src="assets/images/team/hiba.jpg" class="rounded-circle mb-3" width="150" height="150" alt="Membre de l'équipe">
                            <h4>Hiba Kasmi</h4>
                            <p class="text-muted">Experte en Durabilité</p>
                            <p>Veille à ce que tous nos partenaires respectent des normes environnementales strictes.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>