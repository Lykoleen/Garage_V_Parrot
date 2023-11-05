<section class="section_presentation">
    <img class="mercedes" src="../assets/img/mercedes.jpg" alt="background de mercedes">
    <div class="container_presentation">
        <div class="content_presentation">
            <h1>BIENVENUE CHEZ NOTRE GARAGE AUTOMOBILE VINCENT PARROT</h1>
            <p>Que vous recherchiez des services d'entretien, de réparation, ou que vous souhaitiez acheter une voiture d’occasion, vous êtes au bon endroit !</p>
        </div>
        <a href="/annonces/index">
            <button class="btn btn-light btn_presentation">Voir les annonces</button>
        </a>
    </div>
    <div class="overlay"></div>
</section>
<section id="services" class="section_services">
    <h2>NOS SERVICES</h2>
    <div class="presentation_services">
        <div class="card_services">
            <img class="image_services" src="../assets/img/atelier.jpg" alt="photo de réparation d'un phare">
            <h3>L'atelier</h3>
            <p>Notre atelier est l'endroit idéal pour prendre soin de votre véhicule. Que vous ayez besoin d'un entretien régulier ou de réparations mécaniques sur votre voiture, notre équipe de professionnels qualifiés est là pour répondre à tous vos besoins.</p>
        </div>
        <div class="card_services">
            <img class="image_services" src="../assets/img/tuto.jpg" alt="photo de deux personnes dans une voiture">
            <h3>Nos conseils et tutos</h3>
            <p>Nos experts dévoués sont là pour répondre à toutes vos questions, qu'il s'agisse d'entretien de routine, de dépannage en cas de panne, ou même de projets de personnalisation de votre voiture.</p>
        </div>
        <div class="card_services">
            <img class="image_services" src="../assets/img/location.jpg" alt="photo d'un chien qui passe sa tête par la fenêtre de la voiture">
            <h3>La location de véhicules</h3>
            <p>Que vous ayez besoin d'un véhicule pour un voyage d'affaires, des vacances en famille ou tout simplement pour explorer de nouveaux horizons, nous avons la solution idéale pour vous.</p>
        </div>
    </div>
</section>
<section class="section_occasions">
    <h2>NOS VÉHICULES D'OCCASION</h2>
    <?php
    $count = 0;
    ?>
    <?php foreach ($troisDernieres as $annonce) : ?>
        <?php $image = $images[$count]; ?>
        <div class="presentation_occasions">
            <div class="card_occasions">
                <img src="/upload/<?= $image ?>" alt="photo de <?= $annonce['title'] ?>">
                <div class="text_card">
                    <h3><?= $annonce['title'] ?></h3>
                    <div class="p_card">
                        <p><?= $annonce['price'] ?> € |</p>
                        <p><?= $annonce['years'] ?> |</p>
                        <p><?= $annonce['mileage'] ?> kms</p>
                    </div>
                </div>
                <a href="/annonces/lire/<?= $annonce['id'] ?>"><button class="btn btn_annonce">Voir</button></a>
            </div>
        </div>
        <?php $count++ ?>
    <?php endforeach; ?>
    <div class="btn_voir_all_annonces">
        <a href="/annonces/index" class="all_annonces"><button class="btn btn-light">Toutes les annonces</button></a>
    </div>
</section>
<section class="section_avis">
    <div class="container_avis_publies">
        <h2>LES AVIS DE NOS CLIENTS</h2>
        <div class="avis_client_mobile">
            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php $count = 0 ?>
                    <?php foreach ($avisActifs as $avis) : ?>
                        <?php $active = ($count === 0) ? "active" : ''; ?>
                        <div class="carousel-item <?= $active ?>">
                            <div class="container_avis">
                                <div class="note_client">
                                    <img src="../assets/img/etoile<?= $avis['score'] ?>.jpg" alt="Note client égale à <?= $avis['score'] ?>">
                                </div>
                                <h3><?= $avis['surname'] ?> <?= $avis['name'] ?></h3>
                                <p>"<?= $avis['message'] ?>"</p>
                            </div>
                        </div>
                        <?php $count++ ?>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>

    <div id="depot_avis" class="container_depot_avis">
        <?php if (!empty($_SESSION['erreur'])) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $_SESSION['erreur'];
                unset($_SESSION['erreur']) ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['message'])) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $_SESSION['message'];
                unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>

        <h3>Déposez votre avis !</h3>
        <?php echo $form ?>

    </div>



</section>