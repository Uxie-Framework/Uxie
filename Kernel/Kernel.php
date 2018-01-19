<?php

namespace Kernel;

use App\Middleware\Middleware;
use Router\Router;
use Web\Middlewares as Middlewares;

/**
 * execute the application.
 */
class Kernel
{
    private $route;
    private $middleware;

    public function prepare()
    {
        $this->route      = (new Router('../web/Routes.php'))->getRoute();
        $this->middleware = new Middleware($this->route);
    }

    public function start()
    {
        $this->middleware->handle(Middlewares::$priorMiddlewares)->call();
        $this->middleware->handle(Middlewares::$globalMiddlewares)->call();
        $this->launch(new Launcher());
    }

    public function stop()
    {
        $this->middleware->handle(Middlewares::$lateMiddlewares)->call();
    }

    private function launch(Launcher $launcher)
    {
        $launcher->execute($this->route);
    }
}
