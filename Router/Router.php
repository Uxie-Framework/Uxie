<?php
namespace Router;

use App\RequestHandler as Request;
use Exception;

class Router extends web
{
    public $data = [];
    public $route;
    public $url;

    //this method do fetch data and route from requested url
    public function __construct()
    {
        $this->trimUrl();
        if (!$this->route) {
            throw new Exception('Sorry this link does not exist', '404');
        }
        $this->RequestHandle();
    }

    // this method trim request url and find the right route for it
    private function trimUrl()
    {
        $url = urldecode(ltrim($_SERVER['REQUEST_URI'], '/'));
        if (array_key_exists($url, $this->routes)) { // in case requested url exist in routes
            $this->url = $url;
            $this->route = $this->routes[$url];
        } else { // in case requested url don't exist in url (case data passed in url)
            $this->fetchFromUrl($url);
            if (is_array($this->route)) {
                $this->trimRoute();
            }
        }
    }

    // this method fetch data from url
    private function fetchFromUrl(string $url)
    {
        $url = explode('/', $url);
        while (!empty($url)) {
            array_unshift($this->data, str_replace('+', ' ', array_pop($url)));
            if (array_key_exists(implode('/', $url), $this->routes) && !empty($url)) {
                $this->route = $this->routes[implode('/', $url)];
                $this->url = implode('/', $url);
                break;
            }
        }
    }

    // this method is executed in case of complex routes
    private function trimRoute()
    {
        if (!empty($this->data) && is_array($this->route)) {
            $urlRoute = array_shift($this->data);
            $this->url = $this->url.'/'.$urlRoute;
            if (array_key_exists($urlRoute, $this->route)) {
                $this->route = $this->route[$urlRoute];
            }
            if (!empty($this->data) && is_array($this->route)) {
                $this->trimRoute();
            }
        }
        if (is_array($this->route)) {
            $this->route = null;
        }
    }

    // this method add a request object that contains data from POST
    private function RequestHandle()
    {
        $request = new Request();
        if (!$request) { // check if request contain any data (POST only)
            array_unshift($this->data, $request); // merge request into data variable
        }
    }

    // get current request full url.
    public static function getCurrentUrl()
    {
        $router = new self();
        return $router->url.'/'.implode('/', $router->data);
    }

    //return data stored in url.
    public static function data()
    {
        $router = new self();
        return $router->data;
    }
}
