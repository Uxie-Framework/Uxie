<?php

namespace Controllers;

class ErrorsController extends Controller
{
    public function displayError(string $code, string $error)
    {
        if (getenv('PRODUCTION_MODE') == 'ON') {
            $code = 'ERROR';
            $error = '404';
        }
        view('error', ['code' => $code, 'error' => $error]);
    }
}
