<?php

namespace ServiceProviders;

/**
 * Provide short names to the dependency injection container
 */
trait IOCProvider
{
    private $serviceProviders = [
        'Router'     => \Router\Router::class,
        'Kernel'     => \Kernel\Kernel::class,
        'Compiler'   => \Kernel\Compiler\Compiler::class,
        'Middleware' => \App\Middleware\Middleware::class,
        'Dotenv'     => \Dotenv\Dotenv::class,
        'Blade'      => \Jenssegers\Blade\Blade::class,
        'Pug'        => \Pug\Pug::class,
    ];
}
