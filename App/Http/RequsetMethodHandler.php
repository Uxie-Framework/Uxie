<?php
namespace App\Http;

class RequsetMethodHandler
{
    protected $method;

    protected function setMethod()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    public function getMethod()
    {
        return $this->method;
    }
}
