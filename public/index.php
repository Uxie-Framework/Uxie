<?php
/**
 * Uxie - A PHP Micro-Framework.
 *
 * @author Cheribet Mohamed Amine <MohamedAmine1c@gmail.com>
 */

// import composer autoloader
require_once '../vendor/autoload.php';

// use phpdotenv namespace in the vendor folder

use DI\DI;

$container = DI::container();

// specify the filename location to use (.env in the root folder)
$container->build('Dotenv', ['../']);

// load the .env file
$container->get('Dotenv')->load();

// import default settings
require_once '../defaults.php';

// preapring for launching application
$container->build('Kernel');

$container->get('Kernel')->prepare();

// launching application
$container->get('Kernel')->start();

// stop application
$container->get('Kernel')->stop();
