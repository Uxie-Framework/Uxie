<?php

/**
 * Uxie - A PHP Framework.
 *
 * @author M.Amine Cheribet <cheribet.amine@gmail.com>
 */

// Import composer autoloader.
require_once __DIR__.'/../vendor/autoload.php';

// Create IOC container.
IOC\IOC::createContainer();

container()->bind('Dotenv', function () {
    return Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/../');
});
container()->Dotenv->load();

// Load configuration.
require rootDir().'defaults.php';

// Preparing for starting application.
container()->build('Kernel\Kernel');

container()->Kernel->prepare();

// Start the application.
container()->Kernel->start();

// Stop the application.
container()->Kernel->stop();
