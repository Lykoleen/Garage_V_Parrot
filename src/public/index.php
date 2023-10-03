<?php

use App\Core\Router;

define('ROOT', dirname(__DIR__));
// On importe l'autoloader
require_once('../vendor/autoload.php');

// On instancie Router
$app = new Router;

// On démarre l'application
$app->start();

?>