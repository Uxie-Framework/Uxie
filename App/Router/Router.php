<?php
namespace App\Router;

use App\http\RequestHandler as Request;
use Exception;

class Router extends UrlResolver
{
    //this method do fetch data and route from requested url
    public function __construct()
    {
        $this->findRoute();

        if (!$this->route) {
            throw new Exception('Sorry this link does not exist', '404');
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
