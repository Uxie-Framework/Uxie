<?php

namespace App\Router;

use App\http\Request as Request;
use Exception;

class Router
{
    public $route;
    private $routes = [];
    private $url;

    public function __construct()
    {
        $this->url = urldecode(ltrim($_SERVER['REQUEST_URI'], '/'));
        $this->setUp($this);

        if (isset($this->route)) {
            return $this;
        }

        throw new Exception('This Page Does Not Exist', 404);
    }

    private function setUp(Router $router)
    {
        require_once '../web/Routes.php';
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

    private function addRoute(Route $route)
    {
        $this->routes[] = $route;
        $this->validateRoute(new RouteValidator($route, $this->url));
    }

    private function validateRoute(RouteValidator $validator)
    {
        if ($validator->validate()) {
            $this->route = end($this->routes);
            $this->route->setVariablesValues($validator->variables);
            $this->route->setRequest(new Request());
        }
    }

    public function getRoute()
    {
        return $this->route;
    }
}
