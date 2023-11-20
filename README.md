# Garage Vincent Parrot

Intutilé de l'**ECF STUDI**:

Vincent Parrot, fort de ses 15 années d'expérience dans la réparation automobile, a ouvert son propre garage à Toulouse en 2021. Depuis 2 ans, il propose une large gamme de services: réparation de la carrosserie et de la mécanique des voitures ainsi que leur entretien régulier pour garantir leur performance et leur sécurité. De plus, le Garage V. Parrot met en vente des véhicules d'occasion afin d'accroître son chiffre d'affaires. Vincent Parrot considère son atelier comme un véritable lieu de confiance pour ses clients et leurs voitures doivent, selon lui, à tout prix être entre de bonnes mains. Bien qu'il fournisse grâce à ses employés un service de qualité et personnalisé à chaque client, Vincent Parrot reconnaît qu'il doit être visible sur internet s'il veut se faire définitivement une place parmi la concurrence. Il a donc contacté l’agence de création de sites web dont vous faites partie pour un premier devis, qu'il a accepté. Vous aurez alors pour mission de créer une application web vitrine pour le Garage V. Parrot, en mettant en avant la qualité des services délivrés par cette récente entreprise.

## Installer l'appli en local: ⚙️

- Cloner le projet:

    ```
    git clone https://github.com/Lykoleen/Garage_V_Parrot.git
    ```
- Installer les dépendances avec Composer:

    ```
    composer install
    ```
- Importer les fichiers `create_bdd.sql` et `donnees.sql` depuis le dossier `docs` dans votre SGBD. 

- Pour tester l'insertion d'une nouvelle annonce par exemple. Il y a des images de voitures disponibles dans assets/img.

- Pour tester l'ajout d'un avis client. L'activation d'un avis client n'est pas encore disponible depuis le dashboard de l'administrateur. Il faudra donc modifier directement depuis le SGBD la colonne `is_actif` de la table `avis` et passer la valeur à 1 pour que l'avis soit visible sur le site.

## Les technos utilisées: 🎨

| Techno | Version |
|-----------|-----------|
| PHP | 8 . 1 . 10 |
| Composer | 2 . 5 . 8 |
| MYSQL | 8 . 0 . 30 |
| Apache | 2 . 4 . 54 |
| Bootstrap | 5 . 1 . 3 |

## Tester c'est bien ! Mais quoi ? 🔍

#### Connexion Utilisateurs 💻
Un accès sécurisé pour les utilisateurs autorisés, employés et administrateur.

`Le compte admin ne peut être modifié`

| Email | Mot de passe | Role | 
|-----------|-----------|-----------|
| v_parrot@garage.fr | admin | admin
| employe1@garage.fr | employé1 | employé

#### Dashboard d'Administration 📊
Un tableau de bord pour une vue d'ensemble instantanée des possibilités d'administratioin du site. 
1. Les employés pourront:
    - Modérer les avis clients.
    - Modérer les annonces de véhicules d'occasion.
2. L'administrateur pourra:
    - Hériter des droits des employés.
    - Modérer les services proposés par le garage.
    - Modifier les horaires d'ouverture du garage.
    - Ajouter un nouvel employé.

#### Les features en détail:

- **CRUD** Annonces de Véhicules d'Occasion 🚗 <br>
Gérez vos annonces de manière intuitive avec des opérations de création, lecture, mise à jour et suppression pour maintenir votre inventaire à jour.

- **CRUD** Avis Clients 🌟 <br>
 Une fois qu'un avis est envoyé, celui-ci devra être validé depuis le dashboard admin pour être publié.

- **CRUD** Services proposés par le garage 🔧 <br>

- **CRUD** Nouvel employé 🤝 <br>
L'ajout d'un nouvel employé se fera par le biai d'une création d'email avec son mot de passe.

- **Mise à jour** des Horaires d'Ouverture du Garage 🕒 <br>
Flexibilité totale pour ajuster les horaires d'ouverture selon vos besoins.

## Auteur 🖋️

Tony RABILLARD

[Mon Github](https://github.com/Lykoleen)