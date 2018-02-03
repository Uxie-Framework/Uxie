<?php

namespace Kernel\Compiler;

use Router\RouteInterface;
use Closure;

class Compiler
{
    /**
     * Check if Route action is in Closure form or controller form.
     *
     * @param RouteInterface $route
     * @return Mix
     */
    public function compileRoute(Routeinterface $route)
    {
        return $this->compile(new RouteCompiler($route));
    }

    public function compileMiddlewares(array $middlewares)
    {
        return $this->compile(new MiddlewareCompiler($middlewares));
    }

    private function compile($dependencyCompiler)
    {
        $dependencyCompiler->execute();
    }
}
