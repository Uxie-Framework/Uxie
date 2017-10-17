<?php

namespace App\http;

class Request extends RequestDataHandler
{
    public function __construct()
    {
        switch ($this->getMethod()) {
            case 'POST':
                $this->postHandler();
                break;

            default:
                return false;
        }
    }
}
