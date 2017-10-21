<?php

namespace App\middleware;

interface MiddlewareInterface
{
    public function handle();

    public function callMiddlewares();
}
