<?php

namespace App\Middleware;

class MiddlewareHandler
{
    public function __construct(MiddlewareInterface $middleware)
    {
        $middleware->handle();
        $middleware->callMiddlewares();
    }
}
