<h2>Carousel photos voitures ici</h2>
<br>

<article>
    <div class="enteteAnnonce">
        <h1><?= $annonce['title'] ?></h1>
        <p>
        <?= $annonce['years'] ?> 
            - <?= $annonce['mileage'] ?> 
            - <?= $annonce['energy'] ?> 
            - Rapport d'historique disponible
        </p>
        <h2><?= $annonce ['price'] ?> €</h2>
    </div>
    <br>
    <div class="descriptionAnnonce">
        <p><strong>Description :</strong><br><br>
        <?= nl2br($annonce['description']) ?>
        </p>
    </div>
</article>

