<h1 class="mt-2">Listes de toutes les annonces</h1>

<a href="/annonces/ajouter"><button class="btn btn-outline-success my-3">Ajouter une annonce</button></a>

<table class="table table-striped">
    <thead>
        <th>ID</th>
        <th>Titre</th>
        <th>Contenu</th>
        <th>Actif</th>
        <th>Actions</th>
    </thead>
    <tbody>
        <?php foreach($annonces as $annonce): ?>
            <tr>
                <td><?= $annonce['id'] ?></td>
                <td><?= $annonce['title'] ?></td>
                <td><?= $annonce['price'] ?></td>
                <td><?= $annonce['years'] ?></td>
                <td><?= $annonce['mileage'] ?></td>
                <td><?= $annonce['energy'] ?></td>
                <td>
                    <a href="/annonces/modifier/<?= $annonce['id'] ?>" class="btn btn-warning">Modifier</a><a href="/annonces/supprimeAnnonce/<?= $annonce['id'] ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce définitivement ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>