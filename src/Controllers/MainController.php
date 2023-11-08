<?php

namespace App\Controllers;

use App\Models\AnnoncesModel;
use App\Models\AvisModel;
use App\Core\Form;
use App\Models\HorairesModel;

class MainController extends Controller
{
    public function index()
    {
        $annonces = new AnnoncesModel;

        $troisDernieres = $annonces->getAnnoncesDec();

        // Récupération des 3 dernières annonces
        $images = [];
        foreach ($troisDernieres as $annonce) {
            $annoncesImages = $annonces->getImage($annonce['id']);
            foreach ($annoncesImages as $cle => $valeur) {
                $images[] = $valeur;
            }
        }
        $form = new Form;
        $avis = new AvisModel;

        // Récupération des avis clients activés
        $allAvis = $avis->getAllAvis();
        $avisActifs = [];

        foreach ($allAvis as $avis) {
            if ($avis['is_actif'] === 1) {
                $avisActifs[] = $avis;
            }
        }

        // Envoi d'un avis client en bdd
        if (Form::validate($_POST, ['name', 'surname', 'message', 'score'])) {
            $avisModel = new AvisModel;
            $name = strip_tags($_POST['name']);
            $surname = strip_tags($_POST['surname']);
            $message = strip_tags(nl2br($_POST['message']));
            $score = intval($_POST['score']);

            $avisModel->setName($name)
                ->setSurname($surname)
                ->setMessage($message)
                ->setScore($score);

            $avisModel->create();

            $_SESSION['message'] = "L'équipe vous remercie pour votre commentaire. Celui-ci sera validé avant d'être publié";
            header('Location: /#depot_avis');
            exit;
        } else {
            $_SESSION['erreur'] = !empty($_POST) ? "Vous devez remplire tous les champs et donner une note entre 1 et 5 étoiles" : "";
            $name = isset($_POST['name']) ? strip_tags($_POST['name']) : '';
            $surname = isset($_POST['surname']) ? strip_tags($_POST['surname']) : '';
            $message = isset($_POST['message']) ? strip_tags($_POST['message']) : '';
        }

        // form envoi avis client
        $form->debutForm()
            ->ajoutRating(5, 'rating', ['class' => 'star my-2'])
            ->ajoutInput('hidden', 'score', ['id' => 'score', 'value' => ''])
            ->ouvertureDiv(['class' => 'full_name'])
            ->ouvertureDiv(['class' => 'name_client'])
            ->ajoutLabelFor('name', 'Nom')
            ->ajoutInput('text', 'name', ['id' => 'name', 'class' => 'form-control my-2', 'value' => $name])
            ->fermetureDiv()
            ->ouvertureDiv(['class' => 'surname_client'])
            ->ajoutLabelFor('surname', 'Prénom')
            ->ajoutInput('text', 'surname', ['id' => 'surname', 'class' => 'form-control my-2',    'value' => $surname])
            ->fermetureDiv()
            ->fermetureDiv()
            ->ajoutLabelFor('message', 'Message')
            ->ajoutTextarea('message', $message, ['id' => 'message', 'rows' => '10', 'col' => '15', 'class' => 'form-control my-2', 'max-length' => '4000'])
            ->ajoutBouton('Envoyer', ['class' => 'btn mt-3', 'name' => 'Envoyer'])
            ->finForm();

        $horaires = $this->renderHoraires();

        $this->render('main/index', ['troisDernieres' => $troisDernieres, 'images' => $images, 'avisActifs' => $avisActifs, 'horaires' => $horaires ,'form' => $form->create()]);
    }
}
