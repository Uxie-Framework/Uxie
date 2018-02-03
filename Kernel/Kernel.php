<?php

namespace Kernel;

use App;
use Web\Middlewares as Middlewares;

/**
 * execute the application.
 */

class Kernel implements KernelInterface
{
    /**
     * Prepare Application for launching
     * Load necessairy Instances for the application to run
     * Use IOC container to build Router instance
     *
     * @return void
     */
    public function prepare()
    {
        container()->build('Router', [__DIR__.'/../web/Routes.php']);
        container()->build('Compiler');
    }

    /**
     * Start the application
     * Define prior and late Middlewares
     * Launch the application
     * @return void
     */
    public function start()
    {
        container()->Compiler->compileMiddlewares(container()->Router->getRoute()->getMiddlewares());
        container()->Compiler->compileRoute(container()->Router->getRoute());
    }

    /**
     * Last method excuted during application life cycle
     * handle late Middleware
     *
     * @return void
     */
    public function stop()
    {
        //
    }
}
