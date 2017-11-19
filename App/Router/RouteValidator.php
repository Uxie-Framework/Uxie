<?php

namespace App\Router;

class RouteValidator implements RouteValidatorInterface
{
    public $variables = [];
    private $url;
    private $route;

    public function validate(RouteInterface $route, string $url)
    {
        $this->url   = $url;
        $this->route = $route;

        if (!$this->validateMethodType()) {
            return false;
        }

        $urlArray = $this->explodeUrl();

        for ($i = 0; $i < count($this->explodeUrl()); $i++) {
            if ($this->validateUrl($urlArray) && $this->validateVariables($this->variables)) {
                return true;
            }
            $this->variables[] = array_pop($urlArray);
        }

        return false;
    }

    private function explodeUrl()
    {
        $array = explode('/', $this->url);

        if ((count($array) > 1)&&(end($array) == false)) { // remove '/' from urls that with '/';
            array_pop($array);
        }

        return $array;
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
