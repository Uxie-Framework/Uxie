<?php

namespace Kernel;

use App\Middleware\Middleware;
use App\Router\Router;
use Web\Middlewares as Middlewares;

/**
 * excute the application.
 */
class Kernel
{
    private $route;
    private $middleware;

    public function prepare()
    {
        $this->route      = (new Router())->getRoute();
        $this->middleware = new Middleware($this->route);
    }

    public function start()
    {
        $this->middleware->handle(Middlewares::$priorMiddlewares)->call();
        $this->launch(new Launch());
    }

    // this is the last method excuted
    public function stop()
    {
        $this->middleware->handle(Middlewares::$lateMiddlewares)->call();
    }

    private function launch(Launch $launch)
    {
        $launch->execute($this->route);
    }
}
