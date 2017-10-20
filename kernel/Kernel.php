<?php

namespace Kernel;

use App\Http\Request;
use App\Router\Router;
use App\Facade\Request\RequestFacade;
use App\Middleware\MiddlewareHandler as MiddlewareHandler;
use Web\Web as Web;

/**
 * excute the application.
 */
class Kernel
{
    private $request;

    public function prepare()
    {
        $this->request = new RequestFacade(new Request(), new Router());
        MiddlewareHandler::handle(Web::$priorMiddlewares, $this->request->router->url)->callMiddlewares();
    }

    public function start()
    {
        $this->launch();
    }

    // this is the last method excuted
    public function stop()
    {
        MiddlewareHandler::handle(Web::$lateMiddlewares, $this->request->router->url)->callMiddlewares();
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
