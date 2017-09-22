<?php

namespace App;

class throwError
{
    public function __construct($msg, $code)
    {
        log::error($msg, $code);
        route('error/'.$msg.'/'.$code);
    }
}
