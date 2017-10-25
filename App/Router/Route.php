<?php

namespace App\Router;

use App\Http\Request;
use Exception;

class Route implements RouteInterface
{
    public $method;
    public $action;
    public $variables;
    public $route;
    private $trimmed;

    public function __construct(string $method, string $route, $action)
    {
        $this->method  = $method;
        $this->route   = $route;
        $this->action  = $action;
        $this->trimmed = $this->trimRoute(new RouteTrimmer());
    }

    private function trimRoute(RouteTrimmerInterface $trimmer)
    {
        $trimmer->trim($this->route);
        $this->route     = $trimmer->getRealRoute();
        $this->variables = $trimmer->getVariablesNames();

        return $trimmer;
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function getVariables()
    {
        return $this->variables;
    }

    public function setVariablesValues(array $values)
    {
        if (count($values) != count($this->variables)) {
            throw new Exception("Variables Passed Dont Match", 1468);
        }
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
