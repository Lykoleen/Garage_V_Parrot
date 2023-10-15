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
            if (Form::validate($_POST, ['title', 'years', 'price', 'mileage','description', 'energy'])) {
                // Le formulaire est complet
                // On se protège contre les failles xss
                // strip_tags, htmlentities, htmlspecialchars
                $title = strip_tags($_POST['title']);
                $years = strip_tags($_POST['years']);
                $price = strip_tags($_POST['price']);
                $mileage = strip_tags($_POST['mileage']);
                $description = strip_tags(nl2br($_POST['description']));
                $energy = strip_tags($_POST['energy']);

                // ON instancie notre modèle
                $annonce = new AnnoncesModel;

                // On hydrate
                $annonce->setTitle($title)
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
                $title = isset($_POST['title']) ? strip_tags($_POST['title']) : '';
                $years = isset($_POST['years']) ? strip_tags($_POST['years']) : '';
                $price = isset($_POST['price']) ? strip_tags($_POST['price']) : '';
                $mileage = isset($_POST['mileage']) ? strip_tags($_POST['mileage']) : '';
                $description = isset($_POST['description']) ? strip_tags($_POST['description']) : '';
                $energy = isset($_POST['energy']) ? strip_tags($_POST['energy']) : '';
            }


            $form = new Form;
            $formPourImages = new Form;

            $form->debutForm() // Params ne servent que pour l'insertion d'images
                ->ajoutLabelFor('title', 'Titre de l\'annonce :')
                ->ajoutInput(
                    'text',
                    'title',
                    ['id' => 'title', 'class' => 'form-control mb-2', 'value' => $title]
                )
                ->ajoutLabelFor('price', 'Prix :')
                ->ajoutInput('number', 
                'price', 
                ['id' => 'price', 'class' => 'form-control mb-2', 'value' => $price]
                )
                ->ajoutLabelFor('years', 'Année :')
                ->ajoutInput('number', 
                'years', 
                ['id' => 'years', 'class' => 'form-control mb-2', 'value' => $years]
                )
                ->ajoutLabelFor('mileage', 'Kilométrage')
                ->ajoutInput('number', 'mileage', ['id' => 'mileage', 'class' => 'form-control mb-2', 'value' => $mileage]
                )
                ->ajoutLabelFor('', 'Type(s) de carburant :')
                ->ajoutRadio( 
                ['Diesel', 'Essence', 'Hybride', 'Electrique'],
                ['Diesel', 'Essence', 'Hybride', 'Electrique'],
                ['name' => 'energy', 'class' => 'mb-1']
                )
                ->ajoutLabelFor('description', 'Texte de l\'annonce', ['class' => 'mt-2'])
                ->ajoutTextarea('description', $description, ['id' => 'description', 'rows' => '15', 'col' => '20', 'class' => 'form-control my-2', 'max-length' => '4000'])
                
                ->ajoutBouton('Ajouter', ['class' => 'btn btn-primary mt-2', 'name' => 'Ajouter'])
                ->finForm();
            
                // Formulaire d'ajout des images
            $formPourImages->debutForm('post', '/upload/upload', ['class' => 'dropzone','enctype' => 'multipart/form-data'])
                
                ->finForm();
               
            $this->render('annonces/ajouter', ['form' => $form->create(), 'formPourImages' => $formPourImages->create()]);
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

            // On traite le formulaire
            if (Form::validate($_POST, ['title','price' ,'years' ,'mileage' ,'description', 'energy'])) {
                // ON se protège des failles xss
                $title = strip_tags($_POST['title']);
                $price = strip_tags($_POST['price']);
                $years = strip_tags($_POST['years']);
                $mileage = strip_tags($_POST['mileage']);
                $description = strip_tags($_POST['description']);
                $energy = strip_tags($_POST['energy']);

                // On stocke l'annonce
                $annonceModif = new AnnoncesModel;

                // On hydrate
                $annonceModif
                    ->settitle($title)
                    ->setPrice($price)
                    ->setYears($years)
                    ->setMileage($mileage)
                    ->setDescription($description)
                    ->setEnergy($energy);

                // On met à jour l'annonce
                $annonceModif->update($annonce['id']);

                // On redirige
                $_SESSION['message'] = "Votre annonce a été modifiée avec succès";
                header('Location: /');
                exit;
            } else {
                // Le formulaire n'est pas complet
                $_SESSION['erreur'] = !empty($_POST) ? "Tous les champs du formulaire ne sont pas remplis" : "";
            }


            $form = new Form;

            $form->debutForm()
                ->ajoutLabelFor('title', 'Titre de l\'annonce :')
                ->ajoutInput('text', 'title', [
                    'id' => 'title',
                    'class' => 'form-control mb-2',
                    'value' => $annonce['title']
                ])
                ->ajoutLabelFor('price', 'Prix :')
                ->ajoutInput('number', 'price', [
                    'id' => 'price',
                    'class' => 'form-control mb-2',
                    'value' => $annonce['price']
                ])
                ->ajoutLabelFor('years', 'Année :')
                ->ajoutInput('number', 'years', [
                    'id' => 'years',
                    'class' => 'form-control mb-2',
                    'value' => $annonce['years']
                ])
                ->ajoutLabelFor('mileage', 'Kilométrage :')
                ->ajoutInput('number', 'mileage', [
                    'id' => 'mileage',
                    'class' => 'form-control mb-2',
                    'value' => $annonce['mileage']
                ])
                ->ajoutLabelFor('description', 'Description :')
                ->ajoutTextarea(
                    'description',
                    $annonce['description'],
                    ['id' => 'description',
                    'rows' => '10', 
                    'cols' => '10', 
                    'class' => 'form-control mb-2', 
                    'max-length' => '4000']
                )
                ->ajoutLabelFor('energy', 'Séléctionner le carburant avant de valider :', ['class' => 'text-danger fs-3 '])
                ->ajoutRadio( 
                ['Diesel', 'Essence', 'Hybride', 'Electrique'],
                ['Diesel', 'Essence', 'Hybride', 'Electrique'],
                ['name' => 'energy', 'id' => 'energy']
                )
                ->ajoutBouton(
                    'Modifier l\'annonce',
                    ['class' => 'btn btn-primary mt-2', 'name' => 'Ajouter']
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

    /**
     * Supprime une annonce si on est connecté
     *
     * @param [type] $id
     * @return void
     */
    public function supprimeAnnonce(int $id)
    {
        if (isset($_SESSION['user']) && !empty($_SESSION['user']['id']))
        {
            $annonce = new AnnoncesModel;
            $annonce->delete($id);
            header('Location: '.$_SERVER['HTTP_REFERER']);   
        }
    }

}
