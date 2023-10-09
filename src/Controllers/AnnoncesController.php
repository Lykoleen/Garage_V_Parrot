<?php

namespace App\Controllers;

use App\Models\AnnoncesModel;
use App\Core\Form;

class AnnoncesController extends Controller
{
    /**
     * Cette méthode affichera une page listant toutes les annonces de la
     * base de données
     *
     * @return void
     */
    public function index()
    {
        // On instancie le modèle correspondant à la table 'annonces'
        $annonceModel = new AnnoncesModel;
        $annonces = $annonceModel->findAll();
        // On génère la vue
        $this->render('annonces/index', compact('annonces'));
    }

    public function lire(int $id)
    {
        // On instancie le modèle
        $annoncesModel = new AnnoncesModel;
        // On va chercher une annonce
        $annonce = $annoncesModel->find($id);

        // On envoie à la vue
        $this->render('annonces/lire', compact('annonce'));
    }



    public function ajouter()
    {
        // On vérifie si l'utilisateur est connecté
        if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) {
            // L'utilisateur est connecté
            // On vérifie si le formulaire est complet
            if (Form::validate($_POST, ['titre', 'years', 'price', 'mileage','description', 'energy'])) {
                // Le formulaire est complet
                // On se protège contre les failles xss
                // strip_tags, htmlentities, htmlspecialchars
                $titre = strip_tags($_POST['titre']);
                $years = strip_tags($_POST['years']);
                $price = strip_tags($_POST['price']);
                $mileage = strip_tags($_POST['mileage']);
                $description = strip_tags($_POST['description']);
                $energy = strip_tags($_POST['energy']);

                // ON instancie notre modèle
                $annonce = new AnnoncesModel;

                // On hydrate
                $annonce->setTitre($titre)
                    ->setYears($years)
                    ->setPrice($price)
                    ->setMileage($mileage)
                    ->setDescription($description)
                    ->setEnergy($energy);

                // On enregistre
                $annonce->create();

                // On redirige
                $_SESSION['message'] = "Votre annonce a été enregistrée avec succès";
                header('Location: /');
                exit;
            } else {
                // Le formulaire n'est pas complet
                $_SESSION['erreur'] = !empty($_POST) ? "Tous les champs du formulaire ne sont pas remplis" : "";
                $titre = isset($_POST['titre']) ? strip_tags($_POST['titre']) : '';
                $years = isset($_POST['years']) ? strip_tags($_POST['years']) : '';
                $price = isset($_POST['price']) ? strip_tags($_POST['price']) : '';
                $mileage = isset($_POST['mileage']) ? strip_tags($_POST['mileage']) : '';
                $description = isset($_POST['description']) ? strip_tags($_POST['description']) : '';
                $energy = isset($_POST['energy']) ? strip_tags($_POST['energy']) : '';
            }


            $form = new Form;

            $form->debutForm('post', '#', ['encthype' => 'multipart/formdata']) // Params ne servent que pour l'insertion d'images
                ->ajoutLabelFor('titre', 'Titre de l\'annonce :')
                ->ajoutInput(
                    'text',
                    'titre',
                    ['id' => 'titre', 'class' => 'form-control', 'value' => $titre]
                )
                ->ajoutLabelFor('price', 'Prix :')
                ->ajoutInput('number', 
                'price', 
                ['id' => 'price', 'class' => 'form-control', 'value' => $price]
                )
                ->ajoutLabelFor('years', 'Année :')
                ->ajoutInput('number', 
                'years', 
                ['id' => 'years', 'class' => 'form-control', 'value' => $years]
                )
                ->ajoutLabelFor('mileage', 'Kilométrage')
                ->ajoutInput('number', 'mileage', ['id' => 'mileage', 'class' => 'form-control', 'value' => $mileage]
                )
                ->ajoutLabelFor('', 'Type(s) de carburant :')
                ->ajoutRadio(
                ['Diesel', 'Essence', 'Hybride', 'Electrique'],
                ['Diesel', 'Essence', 'Hybride', 'Electrique'],
                
                )
                ->ajoutLabelFor('description', 'Texte de l\'annonce')
                ->ajoutTextarea('description', $description, ['id' => 'description', 'rows' => '15', 'class' => 'form-control'])
                // Cette partie est un exemple pour importer des images
                ->ajoutLabelFor('image', 'Image :')
                ->ajoutInput(
                    'file',
                    'image',
                    ['id' => 'image', 'class' => 'form-control']
                )
                // >Fin de l'exemple
                ->ajoutBouton('Ajouter', ['class' => 'btn btn-primary', 'name' => 'Ajouter'])
                ->finForm();

            $this->render('annonces/ajouter', ['form' => $form->create()]);
        } else {
            // L'utilisateur n'est pas connecté
            $_SESSION['erreur'] = "Vous devez être connecté(e) pour pouvoir accéder à cette page";
            header('Location: /');
            exit;
        }
    }

    public function modifier(int $id)
    {
        if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) {
            // On va vérifier si l'annonce existe dans la base
            // On va instancier notre modèle
            $annonceModel = new AnnoncesModel;

            // On cherche l'annonce avec l'id $id
            $annonce = $annonceModel->find($id);

            // Si l'annonce n'existe pas, on retourne à la liste des annonces
            if (!$annonce) {
                $_SESSION['erreur'] = "L'annonce recherchée n'existe pas";
                header('Location: /annonces');
                exit;
            }

            // On vérifie si l'utilisateur est propriétaire de l'annonce ou admin
            
                if ($annonce['users_id'] !== $_SESSION['user']['id']) {
                    if(!in_array('ROLE_ADMIN', $_SESSION['user']['roles']))
                    {
                        $_SESSION['erreur'] = "Vous n'avez pas accès à cette page";
                        header('Location: /annonces');
                        exit;
                    }
                }


            // On traite le formulaire
            if (Form::validate($_POST, ['titre', 'description'])) {
                // ON se protège des failles xss
                $titre = strip_tags($_POST['titre']);
                $description = strip_tags($_POST['description']);

                // On stocke l'annonce
                $annonceModif = new AnnoncesModel;

                // On hydrate
                $annonceModif
                    ->setTitre($titre)
                    ->setDescription($description);

                // On met à jour l'annonce
                $annonceModif->update($annonce['id']);

                // On redirige
                $_SESSION['message'] = "Votre annonce a été modifiée avec succès";
                header('Location: /');
                exit;
            }


            $form = new Form;

            $form->debutForm()
                ->ajoutLabelFor('titre', 'Titre de l\'annonce :')
                ->ajoutInput('text', 'titre', [
                    'id' => 'titre',
                    'class' =>
                    'form-control',
                    'value' => $annonce['titre']
                ])
                ->ajoutLabelFor('description', 'Texte de l\'annonce')
                ->ajoutTextarea(
                    'description',
                    $annonce['description'],
                    ['id' => 'description', 'class' => 'form-control']
                )
                ->ajoutBouton(
                    'Modifier l\'annonce',
                    ['class' => 'btn btn-primary', 'name' => 'Ajouter']
                )
                ->finForm();

            // On envoie à la vue
            $this->render('annonces/modifier', ['form' => $form->create()]);
        } else {
            // L'utilisateur n'est pas connecté
            $_SESSION['erreur'] = "Vous devez être connecté(e) pour pouvoir accéder à cette page";
            header('Location: /');
            exit;
        }
    }
}
