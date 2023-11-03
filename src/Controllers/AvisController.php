<?php

namespace App\Controllers;

use App\Models\AvisModel;

class AvisController extends Controller
{
    public function index()
    {
        
        
        $this->render('avis/index', compact('allAvis'));
    }
}