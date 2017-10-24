<?php
namespace App\Middleware;

use App\Router\Route;

class Middleware implements MiddlewareInterface
{
    private $route;
    private $middlewaresList = [];

    public function __construct(Route $route)
    {
        $this->route = $route->route;
    }

    public function handle(array $middlewares)
    {
        if (array_key_exists($this->route, $middlewares)) {
            if (!is_array($middlewares[$this->route])) {
                $this->middlewaresList[] = '../Middlewares/'.$middlewares[$this->route].'.php';
            } else {
                foreach ($middlewares[$this->route] as $middleware) {
                    $this->middlewaresList[] = '../Middlewares/'.$middleware.'.php';
                }
            }
        }

        return $this;
    }

    public function call()
    {
        foreach ($this->middlewaresList as $middleware) {
            require_once $middleware;
        }
    }
}
