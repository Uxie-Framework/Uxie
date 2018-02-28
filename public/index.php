<?php
/**
 * Uxie - A PHP Framework.
 *
 * @author M.Amine Cheribet <MohamedAmine1c@gmail.com>
 */

// import composer autoloader
require_once __DIR__.'/../vendor/autoload.php';

use IOC\IOC;

// create IOC container
$container = IOC::container();

// create Dotenv object & specify the filename location to use (.env in the root folder)
$container->build('Dotenv\Dotenv', [__DIR__.'/../']);

// load the .env file
$container->Dotenv->load();

// import default settings
require_once __DIR__.'/../defaults.php';

// preapring for starting application
$container->build('Kernel\Kernel');

$container->Kernel->prepare();

// start the application
$container->Kernel->start();

// stop the application
$container->Kernel->stop();
