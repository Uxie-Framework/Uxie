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
        $this->router->priorMiddleware();
    }

    public function launch()
    {
        $this->execute();
    }

    // this is the last method excuted
    public function stop()
    {
        $this->router->lateMiddleware();
    }

    private function execute()
    {
        if (strpos($this->router->route, '@') && !strpos($this->router->route, '/')) { // if route is in format of Class@method
            $parameters = explode('@', $this->router->route);
            $class = '\Controllers\\'.$parameters[0];
            $method = $parameters[1];
            $route = new $class();
            call_user_func_array([$route, $method], $this->router->data);
        } else { // any other case but Class@method format
            $blade = new Blade('../views', '../cache/blade');
            echo $blade->make($this->router->route);
        }
    }
}
