<?php

namespace App\Controllers;

use App\Models\AnnoncesModel;
use App\Models\AvisModel;
use App\Core\Form;

class MainController extends Controller
{
    public function index()
    {
        $annonces = new AnnoncesModel;

        $troisDernieres = $annonces->getAnnoncesDec();
    
        $images = [];
        foreach ($troisDernieres as $annonce) {
            $annoncesImages = $annonces->getImage($annonce['id']);
            foreach ($annoncesImages as $cle => $valeur) {
                $images[] = $valeur;
            }
        }

        $avis = new AvisModel;
        $allAvis = $avis->getAllAvis();

        if (Form::validate($_POST, ['name', 'surname', 'message', 'score'])) {

            $name = strip_tags($_POST['name']);
            $surname = strip_tags($_POST['surname']);
            $message = strip_tags(nl2br($_POST['message']));
            $score = strip_tags($_POST['score']);

            $avis->setName($name)
                ->setSurname($surname)
                ->setMessage($message)
                ->setScore($score);

            $avis->create();

            $_SESSION['message'] = "L'équipe pour remercie pour votre commentaire. Celui-ci sera validé avant d'être publié";
            exit;
        } else {
            $_SESSION['erreur'] = !empty($_POST) ? "Vous devez remplire tous les champs et donner une note entre 1 et 5 étoiles" : "";
            $name = isset($_POST['name']) ? strip_tags($_POST['name']) : '';
            $surname = isset($_POST['surname']) ? strip_tags($_POST['surname']) : '';
            $message = isset($_POST['message']) ? strip_tags($_POST['message']) : '';
            $score = isset($_POST['score']) ? strip_tags($_POST['score']) : '';
        }

        $form = new Form;

        $form->debutForm()
            ->ajoutRating(5, 'rating', ['class' => 'star my-2', 'id' => 'score'])
            ->ajoutLabelFor('name', 'Nom')
            ->ajoutInput('text', 'name', ['id' => 'name', 'class' => 'form-control my-2', 'value' => $name])
            ->ajoutLabelFor('surname', 'Prénom')
            ->ajoutInput('text', 'surname', ['id' => 'surname', 'class' => 'form-control my-2',    'value' => $surname])
            ->ajoutLabelFor('message', 'Message')
            ->ajoutTextarea('message', $message, ['id' => 'message', 'rows' => '10', 'col' => '15', 'class' => 'form-control my-2', 'max-length' => '4000'])
            ->ajoutBouton('Envoyer', ['class' => 'btn btn-primary mt-2', 'name' => 'Envoyer'])
            ->finForm();
        
        $this->render('main/index', ['troisDernieres' => $troisDernieres, 'images' => $images, 'allAvis' => $allAvis, 'form' => $form->create()]);
    }
}