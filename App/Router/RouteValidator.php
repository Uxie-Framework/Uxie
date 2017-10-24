<?php

namespace App\Router;

class RouteValidator
{
    public $variables = [];
    private $url;
    private $route;

    public function __construct(Route $route, string $url)
    {
        $this->url = $url;
        $this->route = $route;
    }

    private function explode()
    {
        return explode('/', $this->url);
    }

    public function validate()
    {
        $urlArray = $this->explode();

        for ($i = 0; $i < count($this->explode()); $i++) {
            if ($this->validateUrl($urlArray) && $this->validateVariables($this->variables)) {
                return true;
            }
            $this->variables[] = array_pop($urlArray);
        }

        return false;
    }

    private function validateUrl(array $urlArray)
    {
        if ($this->route->route == implode('/', $urlArray)) {
            return true;
        }

        return false;
    }

    private function validateVariables(array $variables)
    {
        if (count($variables) == count($this->route->variables)) {
            return true;
        }

        return false;
    }
}
