<?php $pageTitle = 'Les occasions';
$metaDescription = "Retrouvez ici tous nos véhicules d'occasions parmis une large gamme."
?>

<h1>Les occasions</h1>
<ul>
    <?php foreach ($annonces as $annonce) : ?>
        <a href="/annonces/lire/<?= $annonce['id'] ?>">
            <div class="containerAnnonces">
                <h2><?= $annonce['title'] ?></h2>
                <p><?= $annonce['price'] ?> €</p>
                <ul>
                    <li>
                        <p>Année</p>
                        <p><?= $annonce['years'] ?></p>
                    </li>
                    <li>
                        <p>Kilométrage</p>
                        <p><?= $annonce['mileage'] ?></p>
                    </li>
                    <li>
                        <p>Carburant</p>
                        <p><?= $annonce['energy'] ?></p>
                    </li>
                </ul>
            </div>
            <div class="image">Image à mettre ici </div>
        </a>

    <?php endforeach; ?>
</ul>