<?php

namespace App\Router;

use App\http\RequestHandler as Request;
use Exception;

class Router extends UrlResolver
{
    use RoutesSetters;

    private $routes = [];
    private $url;

    //this method do fetch data and route from requested url
    public function __construct()
    {
        $this->url = urldecode(ltrim($_SERVER['REQUEST_URI'], '/'));
        $this->setUp($this);
    }

    private function setUp(Router $router)
    {
        require_once '../web/routes.php';
    }

    public function get(string $route, $action)
    {
        $this->addRoute(new Route('GET', $route, $action));
    }

    public function post(string $route, $action)
    {
        $this->addRoute(new Route('POST', $route, $action));
    }

    public function group(string $route, Closure $action)
    {
        //
    }

    private function addRoute(RouteInterface $route)
    {
        $this->routes[] = $route;
        $this->checkRoute($route);
    }

    private function checkRoute(CheckRouteInterface $checkRoute)
    {
        //
    }
}
