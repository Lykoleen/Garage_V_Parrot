<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garage V_Parrot - <?= $pageTitle ?? 'Accueil' ?></title>
    <meta name="description" content=<?= $metaDescription ?? "Le garage automobile V_Parrot du lundi au vendredi de 9h à 12h et de 14h à 19h ainsi que le samedi de 8h à 12h. Toute notre équipe est là pour répondre à vos besoins ! Pour réviser ou réparer votre véhicule, ou si vous chercher un véhicules d'occasion. Vous êtes au bon endroit !"?>>
    <meta name="robots" content="noindex, nofollow">
    <meta name="author" content="Rabillard Tony">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/init.css" />
    <link rel="stylesheet" type="text/css" href="/css/main.css" />
    <link rel="stylesheet" type="text/css" href="/css/admin/horaires.css" />
    <link rel="stylesheet" type="text/css" href="/css/header.css" />
    <link rel="stylesheet" type="text/css" href="/css/footer.css" />
    <link rel="stylesheet" type="text/css" href="/css/admin/accueilAdministration.css" />
    <link rel="stylesheet" type="text/css" href="/css/admin/services.css" />
    <link rel="stylesheet" type="text/css" href="/css/admin/employes.css" />
    <link rel="stylesheet" type="text/css" href="/css/admin/annonces.css" />
</head>

<body>
    <header>
        <!-- Ici sera la nav bar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="/"><img width="150" src="<?php realpath(dirname(__DIR__, 1)) ?>/assets/img/logo.svg" alt="logo du garage automobile de monsieur parrot vincent"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="liste_liens navbar-nav me-auto mb-2 mb-lg-0 w-100 justify-content-end">
                        <li class="nav-item me-lg-3 me-xl-4">
                            <a class="link" aria-current="page" href="/">Accueil</a>
                        </li>
                        <li class="nav-item me-lg-3 me-xl-4">
                            <a class="link" href="/#services">Nos Services</a>
                        </li>
                        <li class="nav-item me-lg-3 me-xl-4">
                            <a class="link" href="/annonces">Les Occasions</a>
                        </li>
                        <li class="nav-item me-lg-3 me-xl-4">
                            <a class="link" href="/#section_avis">Déposer un avis</a>
                        </li>
                        <li class="nav-item me-lg-3 me-xl-4">
                            <a class="link" href="/annonces">Contact</a>
                        </li>
                    </ul>
                    <ul class="liste_liens navbar-nav me-auto mb-2 mb-lg-0">
                        <?php
                        if (empty($_SESSION['user']['id'])) : ?>
                            <li class="nav-item me-3 me-lg-4">
                                <a class="ms-lg-5" href="/employes/login"><img width="25" src="../assets/img/iconeconnexion.png" alt="formulaire de connexion"></a>
                            </li>
                        <?php endif; ?>
                        <?php
                        if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) : ?>
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
        <?php if (!empty($_SESSION['erreur'])) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $_SESSION['erreur'];
                unset($_SESSION['erreur']) ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['message'])) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $_SESSION['message'];
                unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>
        <?= $contenu ?>
    </main>

    <footer>
        <div class="container_infos_footer">
            <div class="logo_et_reseaux">
                <img class="logo_blanc" src="<?php realpath(dirname(__DIR__, 1)) ?>/assets/img/logo_blanc.svg" alt="logo du garage automobile de monsieur parrot vincent">
                <div class="reseaux">
                    <a href="https://www.facebook.com/" target="_blank">
                        <img src="<?php realpath(dirname(__DIR__, 1)) ?>/assets/img/facebook.svg" alt="logo du garage automobile de monsieur parrot vincent">
                    </a>
                    <a href="https://twitter.com/" target="_blank">
                        <img class="twitter" src="<?php realpath(dirname(__DIR__, 1)) ?>/assets/img/twitter.svg" alt="logo du garage automobile de monsieur parrot vincent">
                    </a>
                    <a href="https://www.instagram.com/" target="_blank">
                        <img src="<?php realpath(dirname(__DIR__, 1)) ?>/assets/img/instagram.svg" alt="logo du garage automobile de monsieur parrot vincent">
                    </a>
                </div>
            </div>
            <div class="container_hia">
                <div class="horaires">
                    <!-- Controlleur des horaires dans Controller -->
                    <h3>Horaires</h3>
                    <?php foreach ($horaires as $jour => $horaire) : ?>
                        <div class="heures_ouverture">
                            <p><?= substr($jour, 0, 3) ?></p>
                            <p><?= $horaire['ouvertureMatin'][0] ?></p>
                            <p><?= $horaire['fermetureMatin'][0] ?></p>
                            <p><?= $horaire['ouvertureAprem'][0] ?></p>
                            <p><?= $horaire['fermetureAprem'][0] ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="infos_garage">
                    <h3>Informations</h3>
                    <p>Vincent Parrot</p>
                    <div class="p_groupe1">
                        <p>Tél. 01 02 03 04 05</p>
                        <p>garagevparrot@email.com</p>
                    </div>
                    <div class="p_groupe2">
                        <p>45 avenue Général Foch</p>
                        <p>31000 Toulouse</p>
                    </div>
                </div>
                <div class="acces_rapide">
                    <h3>Acces Rapide</h3>
                    <div class="link_acces_rapide">
                        <div class="link_accueil_et_services">
                            <a class="link" href="/">Accueil</a>
                            <a class="link" href="#services">Nos services</a>
                        </div>
                        <div class="link_occasions_et_avis">
                            <a class="link" href="/annonces">Les occasions</a>
                            <a class="link" href="#section_avis">Déposer un avis</a>
                        </div>
                        <div class="link_contact_et_connexion">
                            <a class="link" href="/contact">Contact</a>
                            <a class="link" href="/employes/login">Se connecter</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container_mentions">
            <div class="link_mentions">
                <div class="droits">
                    <a href="">©2023 Garage V.Parrot. Tous droits réservés.</a>
                </div>
                <div class="politique_mentions">
                    <a href="">Politique de confidentialité</a>
                    <a href="">Mentions légales</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script src="/js/note.js"></script>
</body>

</html>