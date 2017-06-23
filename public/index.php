<?php
require_once '../vendor/autoload.php';
require_once '../default.php';

use Router\Router;

$router = new Router();

require_once $router->getView();
