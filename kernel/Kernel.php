<?php

namespace Kernel;

use App\Http\Request;
use App\Router\Router;
use App\Facade\Request\RequestFacade;
use App\Middleware\MiddlewareHandler;
use App\Middleware\PriorMiddleware;
use App\Middleware\lateMiddleware;
use Web\Web as Web;

/**
 * excute the application.
 */
class Kernel
{
    private $request;

    public function prepare()
    {
        //$this->request = new RequestFacade(new Request(), new Router());
        $this->requset = new Router();
        new MiddlewareHandler(new PriorMiddleware($this->request->router));
    }

    public function start()
    {
        $this->launch();
    }

    // this is the last method excuted
    public function stop()
    {
        new MiddlewareHandler(new lateMiddleware($this->request->router));
    }

    private function launch()
    {
        if (strpos($this->request->router->route, '@') && !strpos($this->request->router->route, '/')) { // if route is in format of Class@method
            $parameters = explode('@', $this->request->router->route);
            $class = '\Controllers\\'.$parameters[0];
            $method = $parameters[1];
            $controller = new $class();
            call_user_func_array([$controller, $method], $this->request->router->data);
        } else { // any other case but Class@method format
            view($this->request->router->route);
        }
    }
}
