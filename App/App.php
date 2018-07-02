<?php

/**
 * Created Services that are critical to our application.
 *
 */

container()->bind('Compiler', function() {
    return new Kernel\Compiler\Compiler();
});

container()->bind('Request', function() {
    return new Request\Request();
});

container()->bind('Router', function() {
    return new Router\Router();
});
