<?php

namespace App\Core;

use App\Controllers\MainController;


/**
 * Routeur princpal
 */
class Router 
{
    public function start()
    {
        //On démarre la session
        session_start();

       // On retire le "trailing slash" éventuel de l'URL
       // On récupère l'URL
       $uri = $_SERVER['REQUEST_URI'];
       
       // On vérifie que uri n'est pas vide et se termine par un /
        if(!empty($uri) && $uri[-1] === "/"){
            // On enlève le /
            $uri = substr($uri, 0, -1);

            // On envoie un code de redirection permanante
            http_response_code(301);

            // On redirige vers l'url sans le /
            header('Location: '.$uri);
        }
        
        // On gère les paramètres d'URL
        // p=controleur/methode/parametres
        // On sépare les paramètres dans un tableau
        $params = explode('/', $_GET['p']);

        // var_dump($params);
        if($params[0] != ''){
            // On a au moins un paramètre
            // On récupère le nom du contrôleur à instancier
            // On met une majuscule en première lettre, on ajoute le namespace
            // complet avant et on ajoute "Controller" après$
            $controller = '\\App\\Controllers\\'.ucfirst(array_shift($params)).'Controller';
            // On instancie le contr$oleur
            $controller = new $controller();
            
            // On récupère le deuxième paramètre d'URL
            $action = (isset($params[0])) ? array_shift($params) : 'index';
            if(method_exists($controller, $action))
            {
                // Si il reste des paramètres on les passe à la méthode
                (isset($params[0])) ? call_user_func_array([$controller, $action], $params) : $controller->$action();
            } else {
                http_response_code(404);
                echo 'La page n\'existe pas';
            }
        }else{
            // On a pas de paramètres, on instancie le contrôleur par défaut
            $controller = new MainController;

            // On appelle la méthode index
            $controller->index();
        }
    }
}
?>