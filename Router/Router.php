<?php

namespace Router;

use Exception;

class Router extends web
{
    public $data = [];
    public $route;
    private $url;

    //this method do fetch data and route from requested url
    public function __construct()
    {
        $url = urldecode(ltrim($_SERVER['REQUEST_URI'], '/'));
        if (array_key_exists($url, $this->routes)) { // in case requested url exist in routes
            $this->url   = $url;
            $this->route = $this->routes[$url];
        } else { // in case requested url don't exist in url (case data passed in url)
            $url = explode('/', $url);
            while (!empty($url)) {
                $this->data[] = str_replace('+', ' ', array_pop($url));
                if (array_key_exists(implode('/', $url), $this->routes) && !empty($url)) {
                    $this->route = $this->routes[implode('/', $url)];
                    $this->url   = implode('/', $url);
                    break;
                }
            }
        }
        $this->data = array_reverse($this->data);

        if (empty($this->routes)) {
            throw new Exception('Sorry this link does not exist', '404');
        }
    }

    // this method fetch class and method names and then calls them.
    public function execute()
    {
        if (strpos($this->route, '@') && !strpos($this->route, '/')) { // if route is in format of Class@method
            $parameters = explode('@', $this->route);
            $class      = '\Controllers\\'.$parameters[0];
            $method     = $parameters[1];
            $route      = new $class();
            call_user_func_array([$route, $method], $this->data);
        } else { // any other case but Class@method format
            $this->getView($this->route);
        }
    }

    public static function getView(string $view, array $data = null)
    {
        require_once '../Views/'.$view.'.php';
    }

    //return data stored in url.
    public function getData()
    {
        return $this->data;
    }

    public function priorMiddleware()
    {
        if (array_key_exists($this->url, $this->priorMiddleware)) {
            if (!is_array($this->priorMiddleware[$this->url])) {
                require_once '../Middlewares/'.$this->priorMiddleware[$this->url].'.php';
            } else {
                foreach ($this->priorMiddleware[$this->url] as $key) {
                    require_once '../Middlewares/'.$key.'.php';
                }
            }
        }
    }

    public function lateMiddleware()
    {
        if (array_key_exists($this->url, $this->lateMiddleware)) {
            if (!is_array($this->lateMiddleware[$this->url])) {
                require_once '../Middlewares/'.$this->lateMiddleware[$this->url].'.php';
            } else {
                foreach ($this->lateMiddleware[$this->url] as $key) {
                    require_once '../Middlewares/'.$key.'.php';
                }
            }
        }
    }

    // redirect to a specific url (only inside application);
    public static function route(string $url)
    {
        $host = 'http'.(($_SERVER['SERVER_PORT'] == 443) ? 's://' : '://').$_SERVER['HTTP_HOST'].'/';
        header('Location: '.$host.$url);
    }

    // return full url (only inside application)
    public function url(string $url)
    {
        $host = 'http'.(($_SERVER['SERVER_PORT'] == 443) ? 's://' : '://').$_SERVER['HTTP_HOST'].'/';

        return $host.$url;
    }

    // reidrect to an external url
    public static function redirect(string $url)
    {
        header('Location: '.$url);
    }
    public static function getCurrentRoute()
    {
        return $this->route;
    }
}
