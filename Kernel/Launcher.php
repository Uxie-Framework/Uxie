<?php

namespace Kernel;

use Router\Route;
use Router\RouteInterface;
use Closure;
use Exception;

class Launcher
{
    /**
     * Check if Route action is in Closure form or controller form.
     *
     * @param Route $route
     * @return Mix
     */
    public function execute(RouteInterface $route)
    {
        if ($route->getAction() instanceof Closure) {
            return $this->isClosure($route);
        }

        return $this->isController($route);
    }

    /**
     * Check if route action is a Closure then excute it.
     *
     * @param Closure $action
     * @return void
     */
    private function isClosure(RouteInterface $route): void
    {
        $action = $route->getAction();
        $action(...array_values($route->getVariables()));
    }

    /**
     * Call method from controller if it's a valide controller.
     *
     * @param Route $route
     * @return Mix
     */
    private function isController(RouteInterface $route)
    {
        // if route is in format of Class@method
        if (strpos($route->getAction(), '@') && !strpos($route->getAction(), '/')) {
            $parameters = explode('@', $route->getAction());
            $class = '\Controller\\'.$parameters[0];
            $method = $parameters[1];
            $controller = new $class();
            return call_user_func_array([$controller, $method], $route->getVariables());
        }

        throw new Exception('Route Parameter Error', 1);
    }
}
