<?php

container()->bind('Router', function() {
    return new Router\Router(rootDir().'/App/Routes.php');
});

container()->bind('Compiler', function() {
    return new Kernel\Compiler\Compiler();
});

container()->bind('Dotenv', function() {
    return new Dotenv\Dotenv(__DIR__.'/../');
});
