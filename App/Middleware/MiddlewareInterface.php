<?php

namespace App\Middleware;

interface MiddlewareInterface
{
    public function handle(array $middlewares);

    public function call();
}
