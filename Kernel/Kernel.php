<?php

namespace Kernel;

use Web\Middlewares as Middlewares;
use DI\DI;

/**
 * execute the application.
 */
class Kernel
{
    private $container;

    public function prepare()
    {
        $this->container = DI::container();
        $this->container->build('Router', ['../web/Routes.php']);
        $this->container->build('Middleware', [$this->container->get('Router')->getRoute()]);
    }

    public function start()
    {
        $this->container->get('Middleware')->handle(Middlewares::$priorMiddlewares);
        $this->container->get('Middleware')->handle(Middlewares::$globalMiddlewares);
        $this->launch($this->container->build('Launcher'));
    }

    public function stop()
    {
        $this->container->get('Middleware')->handle(Middlewares::$lateMiddlewares)->call();
    }

    private function launch(Launcher $launcher)
    {
        $launcher->execute($this->container->get('Router')->getRoute());
    }
}
