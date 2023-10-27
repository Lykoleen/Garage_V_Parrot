<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/init.css"/>
    <link rel="stylesheet" type="text/css" href="/css/main.css"/>
    <link rel="stylesheet" type="text/css" href="/css/horaires.css"/>
    <title>Garage V_Parrot - <?= $pageTitle ?? 'Accueil' ?></title>
</head>

<body>
    <header>
        <!-- Ici sera la nav bar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="/"><img width="150" src="<?php realpath(dirname(__DIR__, 1))?>/assets/img/logo.svg" alt="logo du garage automobile de monsieur parrot vincent"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 w-100 justify-content-end">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/annonces">Nos Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/annonces">Nos Occasions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/annonces">Avis Clients</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/annonces">Contactez-nous</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <?php 
                        if(empty($_SESSION['user']['id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link ms-lg-5" href="/employes/login">Connexion</a>
                        </li>
                        <?php endif; ?>
                        <?php 
                        if(isset($_SESSION['user']) && !empty($_SESSION['user']['id'])): ?>   
                            <li class="nav-item">
                                <a class="nav-link ms-lg-5" href="/employes/index">Administration</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/employes/logout">Déconnexion</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container">
        <?php if(!empty($_SESSION['erreur'])): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $_SESSION['erreur']; unset($_SESSION['erreur']) ?>
            </div>
        <?php endif; ?>
        <?php if(!empty($_SESSION['message'])): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>
        <?= $contenu ?>
    </main>

    <script src="/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>