<?php
namespace Kernel;

use Router\Router as Router;

/**
 * This class is responsible for launching the application
 */
class Kernel
{
    private $router;
    public function __construct()
    {
        $this->router = new Router();
    }

    public function launch()
    {
        $this->router->priorMiddleware();
        $this->execute();
        $this->router->lateMiddleware();
    }

    public function execute()
    {
        if (strpos($this->router->route, '@') && !strpos($this->router->route, '/')) { // if route is in format of Class@method
            $parameters = explode('@', $this->router->route);
            $class = '\Controllers\\'.$parameters[0];
            $method = $parameters[1];
            $route = new $class();
            call_user_func_array([$route, $method], $this->rotuer->data);
        } else { // any other case but Class@method format
            view($this->router->route);
        }
    }
}
