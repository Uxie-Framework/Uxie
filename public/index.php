<?php

// import composer autoloader
require_once '../vendor/autoload.php';
//import default settings
require_once '../defaults.php';

use Router\Router;
use Dotenv\Dotenv; // use phpdotenv namespace in the vendor folder

$router = new Router();
$dotenv = new Dotenv('../'); // specify the filename to use (.env in the root folder)
$dotenv->load(); // load the .env file

// middleware to be executed before everything else.
$router->priorMiddleware();
// requiring view related route
require_once $router->getView();
// middleware to be executed after everything else.
$router->lateMiddleware();
