
<div class="container_liste_annonces">

    <h1 class="mt-2">Listes de toutes les annonces</h1>
    
    <a href="/annonces/ajouter"><button class="btn btn-outline-success my-3">Ajouter une annonce</button></a>
    
    <table class="table table-striped">
        <thead>
            <th>Titre</th>
            <th>Prix</th>
            <th>Année</th>
            <th>Kilométrage</th>
            <th>Carburant</th>
            <th>Photo</th>
        </thead>
        <tbody>
            <?php 
                $count = 0;
            ?>
            <?php foreach($annonces as $annonce): ?>
                <?php $image = $images[$count]; ?>
                <tr>
                    <td class="align-middle"><?= $annonce['title'] ?></td>
                    <td class="align-middle"><?= $annonce['price'] ?></td>
                    <td class="align-middle"><?= $annonce['years'] ?></td>
                    <td class="align-middle"><?= $annonce['mileage'] ?></td>
                    <td class="align-middle"><?= $annonce['energy'] ?></td>
                    <td>
                        <img width="200" src="/upload/<?= $image ?>" alt="image de voiture">
                    </td>
                    <td class="align-middle">
                        <a href="/annonces/modifier/<?= $annonce['id'] ?>" class="btn btn-warning me-3">Modifier</a><a href="/annonces/supprimeAnnonce/<?= $annonce['id'] ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce définitivement ?')">Supprimer</a>
                    </td>
                </tr>
                <?php $count++ ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>