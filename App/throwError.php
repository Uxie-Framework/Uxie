<?php

namespace App;

class throwError
{
    public function __construct($error, $code)
    {
        log::error($error, $code);
        if (getenv('PRODUCTION_MODE') == 'ON') {
            $code = 'ERROR';
            $error = '404';
        }
        view('error', ['code' => $code, 'error' => $error]);
    }
}
