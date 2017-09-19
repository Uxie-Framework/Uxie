<?php

namespace Controllers;

use Router\Router as Router;

class ErrorsController extends Controller
{
    public function displayError($code, $error)
    {
        if (getenv('PRODUCTION_MODE') == 'ON') {
            $code = 'ERROR';
            $error = '404';
        }
        Router::getView('error', ['code' => $code, 'error' => $error]);
    }
}
