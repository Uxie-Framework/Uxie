<?php

namespace Kernel;

use Web\Middlewares as Middlewares;

/**
 * execute the application.
 */

class Kernel
{
    /**
     * Prepare Application for launching
     * Load necessairy Instances for the application to run
     * Use IOC container to build Router & Middleware instances
     *
     * @return void
     */
    public function prepare()
    {
        container()->build('Router', [__DIR__.'/../web/Routes.php']);
    }

    /**
     * Start the application
     * Define prior and late Middlewares
     * Launch the application
     * @return void
     */
    public function start()
    {
        $this->launch(container()->build('Launcher'));
    }

    /**
     * Last method excuted during application life cycle
     * handle late Middleware
     *
     * @return void
     */
    public function stop()
    {
    }

    /**
     * Excute application depending on Route
     *
     * @param Launcher $launcher
     * @return void
     */
    private function launch(Launcher $launcher)
    {
        $launcher->execute(container()->Router->getRoute());
    }
}
