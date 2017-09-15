<?php

namespace App;

use Router\Router;

class ThrowError
{
    public function __construct($msg, $code)
    {
        log::error($msg, $code);
        Router::route('error/'.$msg.'/'.$code);
    }
}
