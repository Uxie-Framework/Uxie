<?php

/**
 * Create Services that are critical to our application.
 *
 */

container()->bind('Compiler', function () {
    return new Kernel\Compiler\Compiler();
});

container()->bind('Request', function () {
    return new Request\Request();
});

container()->bind('Response', function () {
    return new Response\Response();
});

container()->bind('Session', function () {
    return new Session\Session();
});

container()->bind('Cookie', function () {
    return new Cookie\Cookie();
});

container()->bind('Router', function () {
    return new Router\Router();
});
