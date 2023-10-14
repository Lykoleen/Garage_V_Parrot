<h1>Bienvenue dans l'interface de l'administration</h1>

<ul>
    <?php if(isset($_SESSION['user']['roles']) && in_array('ROLE_ADMIN', $_SESSION['user']['roles'])): ?>   
        <li><a href="/admin/schedules">Gérer les horaires d'ouvertures</a></li>
        <li><a href="/admin/services">Gérer les services</a></li>
        <li><a href="/admin/accounts">Gérer les comptes employés</a></li>
    <?php endif; ?>
    
    <li><a href="/employes/annonces">Gérer les annonces</a></li>
    <li><a href="/employes/avis">Gérer les avis clients</a></li>
</ul>
