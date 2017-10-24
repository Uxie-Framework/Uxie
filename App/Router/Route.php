<?php

namespace App\Router;

use App\Http\Request;

class Route
{
    public $method;
    public $action;
    public $variables;
    public $route;
    private $trimmed;

    public function __construct(string $method, string $route, $action)
    {
        $this->method = $method;
        $this->route = $route;
        $this->action = $action;
        $this->trimmed = $this->trimRoute(new RouteTrimmer());
    }

    private function trimRoute(RouteTrimmer $trimmer)
    {
        $trimmer->trim($this->route);
        $this->route = $trimmer->getRealRoute();
        $this->variables = $trimmer->getVariables();

        return $trimmer;
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function setVariablesValues(array $values)
    {
        $this->variables = array_combine($this->variables, $values);
    }

    public function setRequest(Request $request)
    {
        if ($this->method != 'POST') {
            return false;
        }
        $this->pushRequest($request);
    }

    private function pushRequest($request)
    {
        array_unshift($this->variables, $request);
    }
}
