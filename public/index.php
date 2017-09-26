<?php
/**
 * Uxie - A PHP Micro-Framework.
 *
 * @author   Cheribet Mohamed Amine <MohamedAmine1c@gmail.com>
 */

// import composer autoloader
require_once '../vendor/autoload.php';

use Dotenv\Dotenv; // use phpdotenv namespace in the vendor folder

$dotenv = new Dotenv('../'); // specify the filename to use (.env in the root folder)
$dotenv->load(); // load the .env file

//import default settings
require_once '../defaults.php';
//preapring for launching application
$Kernel = new Kernel();
// launching application
$Kernel->launch();
