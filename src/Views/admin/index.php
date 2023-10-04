<h1>Bienvenue dans l'interface de l'administration</h1>

<?php if(isset($_SESSION['user']['roles']) && in_array('ROLE_ADMIN', $_SESSION['user']['roles'])): ?>   
    <a href="/admin/schedules">Gérer les horaires d'ouvertures</a>
    <a href="/admin/services">Gérer les services</a>
    <a href="/admin/accounts">Gérer les comptes employés</a>
<?php endif; ?>

<a href="/admin/annonces">Gérer les annonces</a>
<a href="/admin/avis">Gérer les avis clients</a>
