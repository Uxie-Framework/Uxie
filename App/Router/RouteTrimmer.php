<?php

namespace App\Router;

class RouteTrimmer implements RouteTrimmerInterface
{
    public $variables  = [];
    private $realRoute = [];

    public function trim(string $route)
    {
        $this->explode($route);
    }

    private function explode(string $route)
    {
        $this->sifter(explode('/', $route));
    }

    private function sifter(array $routeArray)
    {
        foreach ($routeArray as $value) {
            if ($this->isVariable($value)) {
                $this->variables[] = $this->retrieveVariable($value)[1][0];
            } else {
                $this->realRoute[] = $value;
            }
        }
    }

    private function isVariable(string $value)
    {
        if (empty($this->retrieveVariable($value)[0])) {
            return false;
        }

        return true;
    }

    private function retrieveVariable(string $value)
    {
        preg_match_all('@{\$(.*?)}@', $value, $variables);

        return $variables;
    }

    public function getRealRoute()
    {
        return implode('/', $this->realRoute);
    }

    public function getVariablesNames()
    {
        return $this->variables;
    }
}
