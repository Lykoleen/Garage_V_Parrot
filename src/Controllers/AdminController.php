<?php

namespace App\Controllers;

use App\Models\EmployesModel;
use App\Core\Form;

class AdminController extends Controller
{
    /**
     * Vérifie si on est admin
     *
     * @return boolean
     */
    public function isAdmin()
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
     * Liste des employés
     *
     * @return void
     */
    public function listeEmployes()
    {
        if($this->isAdmin())
        {
                $employesModel = new EmployesModel;
    
                $listeEmployes = $employesModel->findAllRoleEmploye();

                $horaires = $this->renderHoraires();
    
                $this->render('admin/employes/liste', compact('listeEmployes', 'horaires'));

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

        $_SESSION['message'] = "Nouvel employé enregistré avec succès";
        header('Location: /admin/listeEmployes');
        exit;
       } else {
            // Le formulaire n'est pas complet
            $_SESSION['erreur'] = !empty($_POST) ? "Le forumlaire n'est pas complet" : "";
        }



        $form = new Form;

        $form->debutForm()
            ->ajoutLabelFor('email', 'E-mail :')
            ->ajoutInput('email', 'email', ['id' => 'email', 'class' => 'form-control'])
            ->ajoutLabelFor('pass', 'Mot de passe : ')
            ->ajoutInput('password', 'password', ['id' => 'pass', 'class' => 'form-control'])
            ->ajoutBouton('Enregistrer', ['class' => 'btn btn-primary'])
            ->finForm()
            ;

            $horaires = $this->renderHoraires();

            $this->render('admin/employes/register', ['horaires' => $horaires ,'registerForm' => $form->create()]);
        }
    }
    
    /**
     * Modifier les logs d'un employé
     *
     * @param integer $id
     * @return void
     */
    public function modifier(int $id)
    {
        if($this->isAdmin())
        {
            $employesModel = new EmployesModel;

            $employe = $employesModel->find($id);

            // Si l'employé n'existe pas, on retourne à la liste des employés
            if (!$employe) {
                $_SESSION['erreur'] = "L'employé recherché n'existe pas";
                header('Location: /admin/listeEmployes');
                exit;
            }

            if (Form::validate($_POST, ['email', 'password'])) {
                // On se protège des failles xss
                $email = strip_tags($_POST['email']);
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

                $employeModif = new EmployesModel;

                $employeModif
                    ->setEmail($email)
                    ->setPassword($password);

                $employeModif->update($employe['id']);

                $_SESSION['message'] = 'Un compte employé a été modifié avec succès';
                header('Location: /admin/listeEmployes');
                exit;
            } else {
                // Le formulaire n'est pas complet
                $_SESSION['erreur'] = !empty($_POST) ? "Tous les champs doivent être remplis" : "";
            }

            
        $form = new Form;

        $form->debutForm()
            ->ajoutLabelFor('email', 'E-mail :')
            ->ajoutInput('email', 'email', ['id' => 'email', 'class' => 'form-control', 'value' => $employe['email']])
            ->ajoutLabelFor('pass', 'Mot de passe : ')
            ->ajoutInput('password', 'password', ['id' => 'pass', 'class' => 'form-control', 'value' => $employe['password']])
            ->ajoutBouton('Modifier', ['class' => 'btn btn-primary'])
            ->finForm()
            ;

            $horaires = $this->renderHoraires();

            $this->render('admin/employes/modifier', ['horaires' => $horaires ,'modifEmploye' => $form->create()]);
        } else {
            // L'utilisateur n'est pas connecté
            $_SESSION['erreur'] = "Vous devez être connecté(e) pour pouvoir accéder à cette page";
            header('Location: /');
            exit;
        }
    }
    
    public function supprimeEmploye(int $id)
    {
        if($this->isAdmin())
        {
                $employe = new EmployesModel;
                $employe->delete($id);
                header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    }
}
