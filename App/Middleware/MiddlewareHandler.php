<?php
namespace App\middleware;

class MiddlewareHandler implements MiddlewareInterface
{
    private $middlewaresList = [];

    public function __construct()
    {
        return $this;
    }

    public static function handle(array $middlewares, string $route)
    {
        $self = new self();

        if (array_key_exists($route, $middlewares)) {
            if (!is_array($middlewares[$route])) {
                $self->middlewaresList[] = '../Middlewares/'.$middlewares[$route].'.php';
            } else {
                foreach ($middlewares[$route] as $middleware) {
                    $self->middlewaresList[] = '../Middlewares/'.$middleware.'.php';
                }
            }
        }
        return $self;
    }

    public function callMiddlewares()
    {
        foreach ($this->middlewaresList as $middleware) {
            require_once $middleware;
        }
    }

    public function getMiddlewares()
    {
        return $this->middlewaresList;
    }
    public function setMiddleware(string $newMiddleware)
    {
        $this->middlewaresList[] = $newMiddleware;
    }
}
