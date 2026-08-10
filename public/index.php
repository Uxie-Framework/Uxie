<?php

declare(strict_types=1);

/**
 * Uxie - A PHP Framework.
 *
 * @author M.Amine Cheribet <cheribet.amine@gmail.com>
 */

// import composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Create IOC container.
IOC\IOC::createContainer();

container()->bind('Dotenv', function (): \Dotenv\Dotenv {
    return Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/../');
});
container()->Dotenv->load();

// Load configuration
require rootDir() . 'defaults.php';

// preparing for starting application
container()->build('Kernel\Kernel');

container()->Kernel->prepare();

// Start the application.
container()->Kernel->start();

// Stop the application.
container()->Kernel->stop();
