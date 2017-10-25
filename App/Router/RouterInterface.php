<?php

namespace App\Router;

interface RouterInterface
{
    public function get(string $route, $action);
    public function post(string $route, $action);
    public function resource(string $route, string $controller);
    public function getRoute();
}
