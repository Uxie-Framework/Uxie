<?php

namespace App;

use Throwable;

class throwError
{
    public function __construct(Throwable $e)
    {
        log::error($e->getMessage(), $e->getCode(), $e->getLine(), $e->getFile());

        if (getenv('PRODUCTION_MODE') == 'ON') {
            $code = 'ERROR';
            $error = '404';
        }

        view('error', ['code' => $code, 'error' => $error]);
    }
}
