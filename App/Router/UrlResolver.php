<?php

namespace App\Router;

use Web\Web as Web;

class UrlResolver
{
    public $data = [];
    public $route;
    public $url;
    protected $routes;

    // trim request url and find the right route for it
    protected function findRoute()
    {
        $this->url = urldecode(ltrim($_SERVER['REQUEST_URI'], '/'));
        $this->routes = Web::$routes;
        if (array_key_exists($this->url, $this->routes)) { // in case requested url exist in routes
            $this->route = $this->routes[$this->url];
        } else { // in case requested url don't exist in url (case data passed in url)
            $this->fetchData();
            if (is_array($this->route)) {
                $this->resolveComplexRoutes();
            }
        }
    }

    // fetch data from url
    private function fetchData()
    {
        $url = explode('/', $this->url);
        while (!empty($url)) {
            array_unshift($this->data, str_replace('+', ' ', array_pop($url)));
            if (array_key_exists(implode('/', $url), $this->routes) && !empty($url)) {
                $this->route = $this->routes[implode('/', $url)];
                $this->url = implode('/', $url);
                break;
            }
        }
    }

    // resolve multi layer routes
    private function resolveComplexRoutes()
    {
        if (!empty($this->data) && is_array($this->route)) {
            $urlRoute = array_shift($this->data);
            $this->url = $this->url.'/'.$urlRoute;
            if (array_key_exists($urlRoute, $this->route)) {
                $this->route = $this->route[$urlRoute];
            }
            if (!empty($this->data) && is_array($this->route)) {
                $this->resolveComplexRoutes();
            }
        }
        if (is_array($this->route)) {
            $this->route = null;
        }
    }
}
