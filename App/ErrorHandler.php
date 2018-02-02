<?php

namespace App;

use Throwable;

class ErrorHandler
{
    public function __construct(Throwable $e)
    {
        log::error($e->getMessage(), $e->getCode(), $e->getLine(), $e->getFile());
        $code = $e->getCode();
        $error = $e->getMessage();
        if (getenv('PRODUCTION_MODE') == 'ON') {
            $code = 'ERROR';
            $error = '404';
        }

        view('CoreViews/error', ['code' => $code, 'error' => $error]);
    }
}
