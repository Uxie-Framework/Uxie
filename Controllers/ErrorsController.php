<?php

namespace Controllers;

use Router\Router as Router;

class ErrorsController
{
    public function displayError($code, $error)
    {
        Router::getView('error', ['code' => $code, 'error' => $error]);
    }
}
