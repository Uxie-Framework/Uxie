<?php
namespace App\Router;

trait RoutesSetters
{
    public static function get(string $url, $action)
    {
        $router = new Router();
        $router->addRoute(new Route('GET', $url, $action));
    }
}
