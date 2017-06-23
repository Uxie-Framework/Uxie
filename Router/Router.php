<?php
namespace Router;

use App\ThrowError;

class Router extends web
{
    public $data = array();
    public $file;
    public function __construct()
    {
        $url = urldecode(ltrim($_SERVER['REQUEST_URI'], '/'));
        if (array_key_exists($url, $this->routes)) {
            $this->file = '../Views/'.$this->routes[$url].'.php';
        } else {
            $url = explode('/', $url);
            while (!empty($url)) {
                $this->data[] = str_replace('+', ' ', array_pop($url));
                if (array_key_exists(implode('/', $url), $this->routes) && !empty($url)) {
                    $this->file = '../views/'.$this->routes[implode('/', $url)].'.php';
                    break;
                }
            }
        }
        $this->data = array_reverse($this->data);

        if (!file_exists($this->file)) {
            throw new ThrowError('Sorry this link does not exist', '404');
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

    public static function route($url)
    {
        $host = "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s://" : "://") . $_SERVER['HTTP_HOST'].'/';
        header('Location: '.$host.$url);
    }
}
