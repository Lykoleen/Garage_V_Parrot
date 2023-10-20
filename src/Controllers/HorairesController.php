<?php

namespace App\Controllers;

use App\Controllers\AdminController;
use App\Core\Form;
use App\Models\HorairesModel;

class HorairesController extends Controller
{

    public function modifier()
    {
        $instanceAdmin = new AdminController;

        $isAdmin = $instanceAdmin->isAdmin();

        if ($isAdmin) {
            if (isset($_POST['horairesModifiées'])) {

                $horaires = new HorairesModel;
                $joursSemaine = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
                
                
                foreach ($joursSemaine as $jours) {
                    $matin_ouverture = isset($_POST[$jours.'_matin_ouverture']) ? $_POST[$jours.'_matin_ouverture'] : '';
                    $matin_fermeture = isset($_POST[$jours.'_matin_fermeture']) ? $_POST[$jours.'_matin_fermeture'] : '';
                    $aprem_ouverture = isset($_POST[$jours.'_aprem_ouverture']) ? $_POST[$jours.'_aprem_ouverture'] : '';
                    $aprem_fermeture = isset($_POST[$jours.'_aprem_fermeture']) ? $_POST[$jours.'_aprem_fermeture'] : '';
    
                    if (!empty($matin_ouverture) && !empty($matin_fermeture)) {
    
                        $horaires->horairesModif($jours, 'matin', $matin_ouverture, $matin_fermeture);
                    }
    
                    if (!empty($aprem_ouverture) && !empty($aprem_fermeture)) {
    
                        $horaires->horairesModif($jours, 'aprem', $aprem_ouverture, $aprem_fermeture);
                    }
    
                    // Si toutes les plages horaires sont vides, cela signifie que l'entreprise est fermée
    
                    if (empty($matin_ouverture) && empty($aprem_ouverture)) {
    
                        $horaires->horairesModif($jours, 'matin', $matin_ouverture, $matin_fermeture);
                        $horaires->horairesModif($jours, 'aprem', $aprem_ouverture, $aprem_fermeture);
                    }
    
                }

                $_SESSION['message'] = "Les horaires sont modifiés avec succès";
                header('Location: /horaires/modifier');
                exit;
            } else {
                $_SESSION['erreur'] = !empty($_POST) ? "Vous n'avez pas accès à cette page" : '';
            }
        }
       
        $form = new Form;

        $form->debutForm()
            ->ajoutTableHorairesOuvertures()
            ->ajoutBouton('Modifier', ['name' => 'horairesModifiées', 'class' => 'btn btn-primary'])
            ->finForm();
       
        $this->render('admin/horaires/modifier', ['form' => $form->create()]);
    }
}