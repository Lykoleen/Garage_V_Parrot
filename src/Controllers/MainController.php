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

            $name = strip_tags($_POST['name']);
            $surname = strip_tags($_POST['surname']);
            $message = strip_tags(nl2br($_POST['message']));
            $score = intval($_POST['score']);

            $avis->setName($name)
                ->setSurname($surname)
                ->setMessage($message)
                ->setScore($score);

            $avis->create();

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
            ->ajoutLabelFor('name', 'Nom')
            ->ajoutInput('text', 'name', ['id' => 'name', 'class' => 'form-control my-2', 'value' => $name])
            ->ajoutLabelFor('surname', 'Prénom')
            ->ajoutInput('text', 'surname', ['id' => 'surname', 'class' => 'form-control my-2',    'value' => $surname])
            ->ajoutLabelFor('message', 'Message')
            ->ajoutTextarea('message', $message, ['id' => 'message', 'rows' => '10', 'col' => '15', 'class' => 'form-control my-2', 'max-length' => '4000'])
            ->ajoutBouton('Envoyer', ['class' => 'btn mt-3', 'name' => 'Envoyer'])
            ->finForm();

        // Formatage des horaires de l'entreprise pour le footer

        $horairesModel = new HorairesModel;
        $joursSemaine = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
        $horaires = [
            'Lundi' => ['ouvertureMatin' => '', 'fermetureMatin' => '', 'ouvertureAprem' => '', 'fermetureAprem' => ''],
            'Mardi' => ['ouvertureMatin' => '', 'fermetureMatin' => '', 'ouvertureAprem' => '', 'fermetureAprem' => ''],
            'Mercredi' => ['ouvertureMatin' => '', 'fermetureMatin' => '', 'ouvertureAprem' => '', 'fermetureAprem' => ''],
            'Jeudi' => ['ouvertureMatin' => '', 'fermetureMatin' => '', 'ouvertureAprem' => '', 'fermetureAprem' => ''],
            'Vendredi' => ['ouvertureMatin' => '', 'fermetureMatin' => '', 'ouvertureAprem' => '', 'fermetureAprem' => ''],
            'Samedi' => ['ouvertureMatin' => '', 'fermetureMatin' => '', 'ouvertureAprem' => '', 'fermetureAprem' => ''],
            'Dimanche' => ['ouvertureMatin' => '', 'fermetureMatin' => '', 'ouvertureAprem' => '', 'fermetureAprem' => ''],
        ];

        foreach ($joursSemaine as $jour) {
            $horaires[$jour]['ouvertureMatin'] = $horairesModel->getHoraireOuvertureMatin($jour);
            $horaires[$jour]['fermetureMatin'] = $horairesModel->getHoraireFermetureMatin($jour);
            $horaires[$jour]['ouvertureAprem'] = $horairesModel->getHoraireOuvertureAprem($jour);
            $horaires[$jour]['fermetureAprem'] = $horairesModel->getHoraireFermetureAprem($jour);

            if ($horaires[$jour]['ouvertureMatin'] == "00:00") {
                $ouvertureMatin1 = []; // Vide le tableau temporaire à chaque tour de boucle
                $ouvertureMatin1[] = "Fermé";
                $fermetureMatin1[] = "";
                $ouvertureAprem1[] = "";
                $fermetureAprem1[] = "";

                $horaires[$jour]['ouvertureMatin'] = $ouvertureMatin1;
                $horaires[$jour]['fermetureMatin'] = $fermetureMatin1;
                $horaires[$jour]['ouvertureAprem'] = $ouvertureAprem1;
                $horaires[$jour]['fermetureAprem'] = $fermetureAprem1;
            } elseif ($horaires[$jour]['ouvertureMatin'] !== "00:00" && $horaires[$jour]['ouvertureAprem'] == "00:00") {
                $ouvertureMatin2 = []; 
                $ouvertureMatin2[] = "{$horaires[$jour]['ouvertureMatin']} - ";
                $fermetureMatin2 = [];
                $fermetureMatin2[] = $horaires[$jour]['fermetureMatin'];
                $ouvertureAprem2[] = "";
                $fermetureAprem2[] = "";

                $horaires[$jour]['ouvertureMatin'] = $ouvertureMatin2;
                $horaires[$jour]['fermetureMatin'] = $fermetureMatin2;
                $horaires[$jour]['ouvertureAprem'] = $ouvertureAprem2;
                $horaires[$jour]['fermetureAprem'] = $fermetureAprem2;
            } else {
                $ouvertureMatin3 = []; 
                $ouvertureMatin3[] = "{$horaires[$jour]['ouvertureMatin']} - ";
                $fermetureMatin3 = [];
                $fermetureMatin3[] = "{$horaires[$jour]['fermetureMatin']} , ";
                $ouvertureAprem3 = [];
                $ouvertureAprem3[] = "{$horaires[$jour]['ouvertureAprem']} - ";
                $fermetureAprem3 = [];
                $fermetureAprem3[] = $horaires[$jour]['fermetureAprem'];

                $horaires[$jour]['ouvertureMatin'] = $ouvertureMatin3;
                $horaires[$jour]['fermetureMatin'] = $fermetureMatin3;
                $horaires[$jour]['ouvertureAprem'] = $ouvertureAprem3;
                $horaires[$jour]['fermetureAprem'] = $fermetureAprem3;
            }

        }

        $this->render('main/index', ['troisDernieres' => $troisDernieres, 'images' => $images, 'avisActifs' => $avisActifs, 'horaires' => $horaires, 'form' => $form->create()]);
    }
}
