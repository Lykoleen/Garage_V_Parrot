<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\AnnoncesModel;
use App\Models\EmployesModel;

class EmployesController extends Controller
{
    public function index()
    {
        // On vérifie si on est connecté
        if(in_array('ROLE_EMPLOYE', $_SESSION['user']['roles']) || in_array('ROLE_ADMIN', $_SESSION['user']['roles']))
        {
            $horaires = $this->renderHoraires();

            $this->render('employes/index', compact('horaires'));
        }
    }

    public function annonces()
    {
        if(in_array('ROLE_EMPLOYE', $_SESSION['user']['roles']) || in_array('ROLE_ADMIN', $_SESSION['user']['roles']))
        {
            $annoncesModel = new AnnoncesModel;

            $annonces = $annoncesModel->findAll();
        
            $images = [];
            foreach ($annonces as $annonce) {
                $annoncesImages = $annoncesModel->getImage($annonce['id']);
                foreach ($annoncesImages as $cle => $valeur) {
                    $images[] = $valeur;
                }
            }
           
            $horaires = $this->renderHoraires();

            $this->render('employes/annonces', compact('annonces', 'images', 'horaires'));
        }
    }

  
    /**
     * Connexion des utilisateurs
     *
     * @return void
     */
    public function login()
    {
        // On vérifie si le formulaire est complet
        if(Form::validate($_POST, ['email', 'password']))
        {
            //Le formulaire est complet et valide
            // On va chercher dans la base de données l'utilisateur avec l'email entrée
            $employesModel = new EmployesModel;
            $userArray = $employesModel->findOneByEmail(strip_tags($_POST['email']));

            // Si l'utilisateur n'existe pas
            if(!$userArray)
            {
                // On envoie un message de session
                $_SESSION['erreur'] = "L'adresse email ou le mot de passe est incorrect";
                header('Location: /employes/login');
                exit;
            }

            // L'utilisateur existe
            $user = $employesModel->hydrate($userArray);
            // On vérifie si le mot de passe est correct
            if(password_verify($_POST['password'], $user->getPassword()))
            {
                // Le mot de passe est bon, on créer la session
                $user->setSession();
                header('Location: /employes/index');
                exit;
            } else
            {
                // Muavais mot de passe
                $_SESSION['erreur'] = "L'adresse email ou le mot de passe est incorrect";
                header('Location: /employes/login');
                exit;
            }
            
        }
        
        $form = new Form;

        $form->debutForm()
            ->ajoutLabelFor('email', 'E-mail :')
            ->ajoutInput('email', 'email', ['id' => 'email', 'class' => 'form-control'])
            ->ajoutLabelFor('pass', 'Mot de passe : ')
            ->ajoutInput('password', 'password', ['id' => 'pass', 'class' => 'form-control'])
            ->ajoutBouton('Me connecter', ['class' => 'btn btn-primary'])
        ->finForm();

        $horaires = $this->renderHoraires();
        
        $this->render('employes/login', ['horaires' => $horaires ,'loginForm' => $form->create()]);
    }

    /**
     * Déconnexion de l'utilisateur
     *
     * @return void
     */
    public function logout()
    {
        unset($_SESSION['user']);
        header('Location: /');
        exit;
    }
}

?>