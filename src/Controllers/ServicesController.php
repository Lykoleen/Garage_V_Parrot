<?php

namespace App\Controllers;

use App\Controllers\AdminController;
use App\Core\Form;
use App\Models\ServicesModel;

class ServicesController extends Controller
{
    
    public function listeServices()
    {
        $instanceAdmin = new AdminController;

        $isAdmin = $instanceAdmin->isAdmin();

        if ($isAdmin)
        {
            $servicesModel = new ServicesModel;

            $listeServices = $servicesModel->findAll();

            $horaires = $this->renderHoraires();

            $this->render('admin/services/liste', compact('listeServices', 'horaires'));
        }
    }

    public function ajouter()
    {
        $instanceAdmin = new AdminController;

        $isAdmin = $instanceAdmin->isAdmin();

        if ($isAdmin)
        {
            // On vérifie si le formulaire est complet
            if (Form::validate($_POST, ['title'])) {
                // Protection contre les failles xss
                $title = strip_tags($_POST['title']);

                $services = new ServicesModel;

                $services->setTitle($title);

                $services->create();

                $_SESSION['message'] = "Un nouveau service a été enregistré avec succès";
                header('Location: /services/listeServices');
                exit;
            } else {
                // Le formulaire n'est pas complet
                $_SESSION['erreur'] = !empty($_POST) ? "Le forumlaire n'est pas complet" : "";
            }

            $form = new Form;

            $form->debutForm()
                ->ajoutLabelFor('title', 'Nom du service :')
                ->ajoutInput(
                    'text',
                    'title',
                    ['id' => 'title', 'class' => 'form-control mt-2']
                )
                ->ajoutBouton('Enregistrer', ['class' => 'btn btn-primary mt-2'])
                ->finForm();
                
            $horaires = $this->renderHoraires();
            
            $this->render('admin/services/ajouter', ['horaires' => $horaires ,'form' => $form->create()]);

        } else {
            // L'utilisateur n'est pas l'admin
            $_SESSION['erreur'] = "Vous n'avez pas accès à cette page";
            header('Location: /');
            exit;
        }
    }

    public function modifier($id)
    {
        $instanceAdmin = new AdminController;

        $isAdmin = $instanceAdmin->isAdmin();

        if($isAdmin)
        {
            $servicesModel = new ServicesModel;

            $service = $servicesModel->find($id);

            if(!$service) {
                $_SESSION['erreur'] = "Le service recherché est introuvable";
                header('Location: /services/listeServices');
                exit;
            }

            if (Form::validate($_POST, ['title'])) {
                $title = strip_tags($_POST['title']);

                $serviceModif = new ServicesModel;

                $serviceModif->setTitle($title);

                $serviceModif->update($service['id']);

                $_SESSION['message'] = "Votre service a bien été modifié";
                header('Location: /services/listeServices');
                exit;
            } else {
                // Le formulaire n'est pas complet
                $_SESSION['erreur'] = !empty($_POST) ? "Tous les champs doivent être remplis" : "";
            }

            $form = new Form;

            $form->debutForm()
            ->ajoutLabelFor('title', 'Nom du service :')
            ->ajoutInput(
                'text',
                'title',
                ['id' => 'title', 'class' => 'form-control mt-2', 'value' => $service['title']]
            )
            ->ajoutBouton('Enregistrer', ['class' => 'btn btn-primary mt-2'])
            ->finForm();

        $horaires = $this->renderHoraires();

        $this->render('admin/services/modifier', ['horaires' => $horaires ,'form' => $form->create()]);
        }
    }

    public function supprimeServices(int $id)
    {
        $instanceAdmin = new AdminController;

        $isAdmin = $instanceAdmin->isAdmin();

        if($isAdmin)
        {
                $services = new ServicesModel;
                $services->delete($id);
                header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    }
}