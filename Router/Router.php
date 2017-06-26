<?php

namespace Router;

use Exception;

class Router extends web
{
    public $data = [];
    public $file;
    private $url;

    public function __construct()
    {
        $url = urldecode(ltrim($_SERVER['REQUEST_URI'], '/'));
        if (array_key_exists($url, $this->routes)) {
            $this->url = $url;
            $this->file = '../Views/'.$this->routes[$url].'.php';
        } else {
            $url = explode('/', $url);
            while (!empty($url)) {
                $this->data[] = str_replace('+', ' ', array_pop($url));
                if (array_key_exists(implode('/', $url), $this->routes) && !empty($url)) {
                    $this->file = '../views/'.$this->routes[implode('/', $url)].'.php';
                    $this->url = implode('/', $url);
                    break;
                }
            }
        }
        $this->data = array_reverse($this->data);

        if (!file_exists($this->file)) {
            throw new Exception('Sorry this link does not exist', '404');
        }
    }

    public function getView()
    {
        return $this->file;
    }

    public function getData()
    {
        return $this->data;
    }

    public function priorMiddleware()
    {
        if (array_key_exists($this->url, $this->priorMiddleware)) {
            require_once '../Middlewares/'.$this->priorMiddleware[$this->url].'.php';
        }
    }

    public function lateMiddleware()
    {
        if (array_key_exists($this->url, $this->lateMiddleware)) {
            require_once '../Middlewares/'.$this->lateMiddleware[$this->url].'.php';
        }
    }

    public static function route($url)
    {
        $host = 'http'.(($_SERVER['SERVER_PORT'] == 443) ? 's://' : '://').$_SERVER['HTTP_HOST'].'/';
        header('Location: '.$host.$url);
    }
}
