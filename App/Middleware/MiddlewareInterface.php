<?php

namespace App\Middleware;

use App\Router\RouteInterface;

interface MiddlewareInterface
{
    public function __construct(RouteInterface $route);
    public function handle(array $middlewares);
    public function call();
}
