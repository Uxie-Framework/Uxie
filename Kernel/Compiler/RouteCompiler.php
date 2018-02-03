<?php

namespace Kernel\Compiler;

use Router\RouteInterface;
use Closure;

class RouteCompiler implements DependencyCompilerInterface
{
    private $route;

    public function __construct(RouteInterface $route)
    {
        $this->route = $route;
    }

    public function execute()
    {
        if ($this->route->getAction() instanceof Closure) {
            return $this->callClosure($this->route);
        }

        if ($this->isController($this->route)) {
            return $this->executeController();
        }

        throw new \Exception('Route Parameter Error', 1);
    }

    /**
     * Check if route action is a Closure then excute it.
     *
     * @param Closure $action
     * @return void
     */
    private function callClosure(RouteInterface $route): void
    {
        $action = $route->getAction();
        $action(...array_values($route->getVariables()));
    }

    /**
     * Call method from controller if it's a valide controller.
     *
     * @param RouteInterface $route
     * @return Mix
     */
    private function isController(RouteInterface $route)
    {
        // check if route is in format of Class@method
        if (strpos($route->getAction(), '@') && !strpos($route->getAction(), '/')) {
            return true;
        }
        return false;
    }

    private function executeController(RouteInterface $route)
    {
        $parameters = $this->explodeController($route);
        $controller = new $parameters['controller'];
        return call_user_func_array([$controller, $parameters['method']], $route->getVariables());
    }

    private function explodeController(RouteInterface $route)
    {
        $parameters = explode('@', $route->getAction());
        return [
            'controller' => '\Controller\\'.$parameters[0],
            'method' => $parameters[0],
        ];
    }
}
