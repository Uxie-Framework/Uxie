<?php
namespace Kernel;

use Router\Router as Router;
use Jenssegers\Blade\Blade;

/**
 * This class is responsible for launching the application
 */
class Kernel
{
    private $router;

    public function __construct()
    {
        $this->router = new Router();
        $this->priorMiddleware();
    }

    public function launch()
    {
        $this->execute();
    }

    // this is the last method excuted
    public function stop()
    {
        $this->lateMiddleware();
    }

    private function execute()
    {
        if (strpos($this->router->route, '@') && !strpos($this->router->route, '/')) { // if route is in format of Class@method
            $parameters = explode('@', $this->router->route);
            $class      = '\Controllers\\'.$parameters[0];
            $method     = $parameters[1];
            $route      = new $class();
            call_user_func_array([$route, $method], $this->router->data);
        } else { // any other case but Class@method format
            view($this->router->route);
        }
    }

    private function priorMiddleware()
    {
        if (array_key_exists($this->router->url, $this->router->priorMiddleware)) {
            if (!is_array($this->router->priorMiddleware[$this->router->url])) {
                require_once '../Middlewares/'.$this->router->priorMiddleware[$this->router->url].'.php';
            } else {
                foreach ($this->router->priorMiddleware[$this->router->url] as $key) {
                    require_once '../Middlewares/'.$key.'.php';
                }
            }
        }
    }

    private function lateMiddleware()
    {
        if (array_key_exists($this->router->url, $this->router->lateMiddleware)) {
            if (!is_array($this->router->lateMiddleware[$this->router->url])) {
                require_once '../Middlewares/'.$this->router->lateMiddleware[$this->router->url].'.php';
            } else {
                foreach ($this->router->lateMiddleware[$this->router->url] as $key) {
                    require_once '../Middlewares/'.$key.'.php';
                }
            }
        }
    }
}
