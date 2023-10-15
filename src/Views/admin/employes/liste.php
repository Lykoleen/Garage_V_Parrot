<h1>Liste des employés</h1>

<a href="/admin/register"><button class="btn btn-outline-success my-3">Ajouter un(e) employé(e)</button></a>

<table class="table table-striped">
    <thead>
        <th>ID</th>
        <th>Email</th>
        <th>Mot de passe</th>
    </thead>
    <tbody>
        <?php foreach($listeEmployes as $employes) : ?>
            <tr>
                <td><?= $employes['email'] ?></td>
                <td><?= $employes['password'] ?></td>
                <td>
                    <a href="/admin/modifier/<?= $employes['id'] ?>" class="btn btn-warning">Modifier</a><a href="/admin/supprimeEmploye/<?= $employes['id'] ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet employé définitivement ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
