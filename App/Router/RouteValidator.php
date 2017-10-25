<?php

namespace App\Router;

class RouteValidator implements RouteValidatorInterface
{
    public $variables = [];
    private $url;
    private $route;

    private function explode()
    {
        return explode('/', $this->url);
    }

    public function validate(RouteInterface $route, string $url)
    {
        $this->url   = $url;
        $this->route = $route;

        if (!$this->validateMethodType()) {
            return false;
        }

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
        if ($this->route->getRoute() == implode('/', $urlArray)) {
            return true;
        }

        return false;
    }

    private function validateVariables(array $variables)
    {
        if (count($variables) == count($this->route->getVariables())) {
            return true;
        }

        return false;
    }

    private function validateMethodType()
    {
        if ($_SERVER['REQUEST_METHOD'] == $this->route->getMethod()) {
            return true;
        }
    }
}
