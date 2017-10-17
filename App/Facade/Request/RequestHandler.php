<?php

namespace App\Facade\Request;

use App\http\Request;
use App\Router\Router;

class RequestHandler
{
    public $router;
    public $request;

    public function __construct()
    {
        $this->handleRequest();
        if (!$this->request) {
            array_unshift($this->router->data, $this->request);
        }
    }

    public function handleRequest()
    {
        $this->request = new Request();
        $this->router = new Router();
    }
}
