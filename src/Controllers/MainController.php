<?php

namespace App\Controllers;

use App\Models\AnnoncesModel;

class MainController extends Controller
{
    public function index()
    {
        $annonces = new AnnoncesModel;

        $troisDernieres = $annonces->getAnnoncesDec();
    
        $images = [];
        foreach ($troisDernieres as $annonce) {
            $annoncesImages = $annonces->getImage($annonce['id']);
            foreach ($annoncesImages as $cle => $valeur) {
                $images[] = $valeur;
            }
        }

        $this->render('main/index', compact('troisDernieres', 'images'));
    }
}