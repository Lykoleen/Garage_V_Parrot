<?php

namespace App\Controllers;

use App\Models\AnnoncesModel;
use App\Models\EmployesModel;
use App\Core\Form;

class AdminController extends Controller
{
    public function index()
    {
        // On vérifie si on est admin
        if(in_array('ROLE_EMPLOYE', $_SESSION['user']['roles']) || $this->isAdmin())
        {
            $this->render('admin/index');
        }
    }


    /**
     * Vérifie si on est admin
     *
     * @return boolean
     */
    private function isAdmin()
    {
        // On vérifie si on est connecté et si "ROLE_ADMIN" est dans nos rôles
        if(isset($_SESSION['user']) && in_array('ROLE_ADMIN', $_SESSION['user']['roles']))
        {
            // On est admin
            return true;
        } else {
            // On est pas admin
            $_SESSION['erreur'] = "Vous n'avez pas accès à cette page";
            header('Location: /');
            exit;
        }
    }

    /**
     * Inscription des utilisateurs
     *
     * @return void
     */
    public function register()
    {
        if($this->isAdmin())
        {
            // On vérifie si le forumlaire est valide
       if(Form::validate($_POST, ['email', 'password']))
       {
      
        // On "nettoie" l'adresse email
        $email = strip_tags($_POST['email']);

        // On chiffre le mot de passe
        $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
        
        // On stock l'utilisateur en base de données
        $user = new EmployesModel;

        $user->setEmail($email)
            ->setPassword($pass);

        $user->create();
       }


        $form = new Form;

        $form->debutForm()
            ->ajoutLabelFor('email', 'E-mail :')
            ->ajoutInput('email', 'email', ['id' => 'email', 'class' => 'form-control'])
            ->ajoutLabelFor('pass', 'Mot de passe : ')
            ->ajoutInput('password', 'password', ['id' => 'pass', 'class' => 'form-control'])
            ->ajoutBouton('M\'inscrire', ['class' => 'btn btn-primary'])
            ->finForm()
            ;

            $this->render('admin/register', ['registerForm' => $form->create()]);
        }
    }
       

}
