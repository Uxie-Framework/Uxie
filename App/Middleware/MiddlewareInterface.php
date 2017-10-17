<?php

namespace App\middleware;

interface MiddlewareInterface
{
    public static function handle(array $middlewares, string $route);

    public function callMiddlewares();

    public function getMiddlewares();

    public function setMiddleware(string $newMiddleware);
}
