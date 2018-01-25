<?php

namespace App;

/**
 * Provide short names to the dependency injection container
 */
trait ServiceProvider
{
    private $serviceProviders = [
        'Router'     => \Router\Router::class,
        'Kernel'     => \Kernel\Kernel::class,
        'Launcher'   => \Kernel\Launcher::class,
        'Middleware' => \App\Middleware\Middleware::class,
        'Dotenv'     => \Dotenv\Dotenv::class,
        'Blade'      => \Jenssegers\Blade\Blade::class,
        'Pug'        => \Pug\Pug::class,
    ];
}
