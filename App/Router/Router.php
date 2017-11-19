<?php

namespace App\Router;

use App\http\Request as Request;
use Exception;
use Closure;

class Router implements RouterInterface
{
    private $route;
    private $routes = [];
    private $url;
    private $prefix = '';

    public function __construct()
    {
        $this->url = urldecode(ltrim($_SERVER['REQUEST_URI'], '/'));
        $this->setUp($this);

        if (isset($this->route)) {
            return $this;
        }

        throw new Exception('This Page Does Not Exist', 404);
    }

    private function setUp(RouterInterface $router)
    {
        require_once '../web/Routes.php';
    }

    public function get(string $route, $action)
    {
        $this->addRoute(new Route('GET', $this->prefix, $route, $action));
    }

    public function post(string $route, $action)
    {
        $this->addRoute(new Route('POST', $this->prefix, $route, $action));
    }

    public function resource(string $route, string $controller)
    {
        $this->get("$route", "$controller@index");
        $this->get("$route/create", "$controller@create");
        $this->post($route, "$controller@store");
        $this->get($route.'/{$id}', "$controller@show");
        $this->get($route.'/edit/{$id}', "$controller@edit");
        $this->post($route.'/update/{$id}', "$controller@update");
        $this->post($route.'/destroy/{$id}', "$controller@delete");
    }

    public function group(string $prefix, Closure $action)
    {
        $this->prefix = $prefix;
        $action();
        $this->initialisePrefix();
    }

    private function initialisePrefix()
    {
        $this->prefix = '';
    }

    private function addRoute(RouteInterface $route)
    {
        $this->routes[] = $route;
        $this->validateRoute(new RouteValidator());
    }

    private function validateRoute(RouteValidatorInterface $validator)
    {
        if ($validator->validate(end($this->routes), $this->url)) {
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
