<?php
/**
 * Uxie - A PHP Micro-Framework.
 *
 * @author Cheribet Mohamed Amine <MohamedAmine1c@gmail.com>
 */

// import composer autoloader
require_once '../vendor/autoload.php';

// use phpdotenv namespace in the vendor folder
use Dotenv\Dotenv;
use Kernel\Kernel;
use Router\Router;
// specify the filename location to use (.env in the root folder)
$dotenv = new Dotenv('../');
// load the .env file
$dotenv->load();

// import default settings
require_once '../defaults.php';

// preapring for launching application
$Kernel = new Kernel();

$Kernel->prepare();

// launching application
$Kernel->start();

// stop application
$Kernel->stop();
