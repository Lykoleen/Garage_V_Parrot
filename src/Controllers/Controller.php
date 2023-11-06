<?php

namespace App\Controllers;

use App\Models\HorairesModel;
abstract class Controller
{
    public function render(string $fichier, array $donnees = [], string $template = "default")
    {   
        // On extrait le contenu de $donnees
        extract($donnees);

        // On démarre le buffer de sortie, ce qui va permettre mettre en mémoire
        // tout ce qui en dans le buffer et ensuite, l'injecter dans une variable

        ob_start();
        
        // On créer le chemin vers la vue
        require_once ROOT.'/Views/'.$fichier.'.php';
        
        $contenu = ob_get_clean();

        require_once ROOT.'/Views/default/'.$template.'.php';
    }

    public function renderHoraires()
    {
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

        return $horaires;
    }
}