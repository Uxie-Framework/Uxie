<?php

namespace App\Http;

class Request
{
    private $variables = [];

    public function __construct()
    {
        $this->handleData(new RequestDataHandler);
    }

    private function handleData(RequestDataHandler $handler)
    {
        $this->variables = $handler->handle();
    }

    public function __set($name, $value)
    {
        $this->variables[$name] = $value;
    }

    public function __get($name)
    {
        return $this->variables[$name];
    }
}
