<?php

namespace App\Controllers;

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

        require_once ROOT.'/Views/'.$template.'.php';
    }
}