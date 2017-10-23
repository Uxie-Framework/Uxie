<?php

namespace App\Router;

/**
 *
 */
class RouteTrimmer implements RouteTrimmerInterface
{
    public $variables = [];
    private $realRoute = [];

    public function __construct(string $route)
    {
        $this->realRoute = $this->trim($route);
    }

    private function trim(string $route)
    {
        return $this->explode($route);
    }

    private function explode(string $route)
    {
        return $this->sifter(explode('/', $route));
    }

    private function sifter(array $routeArray)
    {
        foreach ($routeArray as $value) {
            if (isVariable($value)) {
                $this->variables[] = $value;
            } else {
                $this->realRoute[] = $values;
            }
        }
    }

    private function isVariable(string $value)
    {
        preg_match_all('/\{$.*?\}/', $value, $validate);
        if (empty($validate)) {
            return false;
        }
        return true;
    }

    public function getRealRoute()
    {
        return implode('/', $this->realRoute);
    }
}
