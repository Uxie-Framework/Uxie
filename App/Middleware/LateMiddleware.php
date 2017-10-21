<?php
namespace App\Middleware;

use App\Router\Router;
use Web\Web;

class PriorMiddleware implements MiddlewareInterface
{
    private $route;
    private $middlewares;
    private $middlewaresList = [];

    public function __construct(Router $router)
    {
        $this->route = $router->route;
        $this->middlewares = Web::$lateMiddlewares;
    }

    public function handle()
    {
        if (array_key_exists($this->route, $this->middlewares)) {
            if (!is_array($this->middlewares[$this->route])) {
                $this->middlewaresList[] = '../Middlewares/'.$this->middlewares[$this->route].'.php';
            } else {
                foreach ($this->middlewares[$this->route] as $middleware) {
                    $this->middlewaresList[] = '../Middlewares/'.$middleware.'.php';
                }
            }
        }

        return $this;
    }

    public function callMiddlewares()
    {
        foreach ($this->middlewaresList as $middleware) {
            require_once $middleware;
        }
    }
}
