<?php

namespace App\Router;

use Closure;

interface RouterInterface
{
    public function get(string $route, $action);
    public function post(string $route, $action);
    public function resource(string $route, string $controller);
    public function group(string $prefix, Closure $action);
    public function getRoute();
}
