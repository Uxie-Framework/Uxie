<?php

declare(strict_types=1);

/**
 * Create Services that are critical to our application.
 */

container()->bind('Compiler', function (): Kernel\Compiler\Compiler {
    return new Kernel\Compiler\Compiler();
});

container()->bind('Request', function (): Request\Request {
    return new Request\Request();
});

container()->bind('Response', function (): Response\Response {
    return new Response\Response();
});

container()->bind('Session', function (): Session\Session {
    return new Session\Session();
});

container()->bind('Cookie', function (): Cookie\Cookie {
    return new Cookie\Cookie();
});

container()->bind('Router', function (): Router\Router {
    return new Router\Router();
});
