<?php

namespace Kernel;

use Router\Route;
use Closure;
use Exception;

class Launcher
{
    public function execute(Route $route)
    {
        if (is_callable($route->getAction())) {
            $this->isClosure($route->getAction());

            return true;
        }

        $this->isController($route);
    }

    private function isClosure(Closure $action)
    {
        $action();
    }

    private function isController(Route $route)
    {
        if (strpos($route->action, '@') && !strpos($route->action, '/')) { // if route is in format of Class@method
            $parameters = explode('@', $route->action);
            $class = '\Controller\\'.$parameters[0];
            $method = $parameters[1];
            $controller = new $class();
            call_user_func_array([$controller, $method], $route->variables);

            return true;
        }

        throw new Exception('Route Parameter Error', 1);
    }
}
