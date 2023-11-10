<section class="section_presentation">
    <div class="mercedes">
        <img src="../assets/img/mercedes.jpg" alt="background de mercedes">
    </div>
    <div class="container_presentation">
        <div class="content_presentation">
            <h1>BIENVENUE CHEZ NOTRE GARAGE AUTOMOBILE VINCENT PARROT</h1>
            <p>Que vous recherchiez des services d'entretien, de réparation, ou que vous souhaitiez acheter une voiture d’occasion, vous êtes au bon endroit !</p>
            <a href="/annonces/index">
                <button class="btn btn-light btn_presentation">Voir les annonces</button>
            </a>
        </div>
    </div>
    <div class="overlay"></div>
</section>
<section id="services" class="section_services">
    <h2>NOS SERVICES</h2>
    <div class="presentation_services">
        <?php $countService = 0 ?>
        <?php foreach ($services as $service) : ?>
            <?php $imageService = $imagesServices[$countService] ?>
            <div class="card_services">
                <img class="image_services" src="/upload/<?= $imageService ?>" alt="photo du service <?= $service['title'] ?>">
                <h3><?= $service['title'] ?></h3>
                <p>"<?= $service['description'] ?>"</p>
            </div>
        <?php $countService++ ?>
        <?php endforeach; ?>
        
    </div>
</section>
<section class="section_occasions">
    <h2>NOS VEHICULES D'OCCASION</h2>
    <?php
    $count = 0;
    ?>
    <div class="container_annonces">
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
    </div>
    <div class="btn_voir_all_annonces">
        <a href="/annonces/index" class="all_annonces"><button class="btn btn-light">Toutes les annonces</button></a>
    </div>
</section>
<section id="section_avis" class="section_avis">
    <div class="container_avis_publies">
        <h2>LES AVIS DE NOS CLIENTS</h2>
        <div class="avis_client_mobile">
            <div id="carouselExampleControls" class="carousel carousel-dark slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php for ($i = 0; $i < count($avisActifs); $i += 2) : ?>
                        <?php $avis1 = $avisActifs[$i]; // Premier avis
                        $avis2 = ($i + 1 < count($avisActifs)) ? $avisActifs[$i + 1] : null; // Deuxième avis (s'il existe)
                        ?>
                        <div class="carousel-item <?= ($i === 0) ? "active" : '' ?>">
                            <div class="all_container_avis">
                                <div class="container_avis">
                                    <div class="note_client">
                                        <img src="../assets/img/etoile<?= $avis1['score'] ?>.jpg" alt="Note client égale à <?= $avis1['score'] ?>">
                                    </div>
                                    <h3><?= $avis1['surname'] ?> <?= $avis1['name'] ?></h3>
                                    <p>"<?= $avis1['message'] ?>"</p>
                                </div>
                                <?php if ($avis2) : ?>
                                    <div class="container_avis_2">
                                        <div class="note_client">
                                            <img src="../assets/img/etoile<?= $avis2['score'] ?>.jpg" alt="Note client égale à <?= $avis2['score'] ?>">
                                        </div>
                                        <h3><?= $avis2['surname'] ?> <?= $avis2['name'] ?></h3>
                                        <p>"<?= $avis2['message'] ?>"</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endfor; ?>
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

        <h3>Deposez votre avis !</h3>
        <?php echo $form ?>

    </div>



</section>