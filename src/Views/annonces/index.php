<h1>Liste des annonces</h1>
    <ul>
        <?php foreach ($annonces as $annonce) : ?>
            <li>
                <h2>Annonce</h2>
                <ul>
                    <?php foreach ($annonce as $cle => $valeur) : ?>
                        <li><strong><?php echo $cle; ?>:</strong> <?php echo $valeur; ?></li>
                    <?php endforeach; ?>
                </ul>
            </li>
        <?php endforeach; ?>
    </ul>