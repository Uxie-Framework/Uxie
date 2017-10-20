<?php

namespace App\Facade\Request;

use App\http\Request;
use App\Router\Router;

class RequestFacade
{
    public $router;
    public $request;

    public function __construct(Request $request, Router $router)
    {
        $this->request = $request;
        $this->router = $router;

        if (!$this->request) {
            array_unshift($this->router->data, $this->request);
        }
    }
}
