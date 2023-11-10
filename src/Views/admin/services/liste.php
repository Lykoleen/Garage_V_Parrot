<div class="container_liste_services">
    <h1>Liste des services</h1>
    
    <a href="/services/ajouter"><button class="btn btn-outline-success my-3">Ajouter un service</button></a>
    
    <table class="table table-striped">
        <thead>
            <th>Titre</th>
            <th>Description</th>
        </thead>
        <tbody>
            <?php foreach($listeServices as $services) : ?>
                <tr>
                    <td><?= $services['title'] ?></td>
                    <td><?= $services['description'] ?></td>
                    <td>
                        <a href="/services/modifier/<?= $services['id'] ?>" class="btn btn-warning">Modifier</a><a href="/services/supprimeServices/<?= $services['id'] ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce service définitivement ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
