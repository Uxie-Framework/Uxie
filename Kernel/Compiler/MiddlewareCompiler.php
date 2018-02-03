<?php

namespace Kernel\Compiler;

class MiddlewareCompiler
{
    private $middlewares;

    public function __construct(array $middlewares)
    {
        $this->middlewares = $middlewares;
    }

    public function execute()
    {
        foreach ($this->middlewares as $middleware) {
            $this->CallFromArray($middleware->getMiddlewares());
        }
    }

    private function callFromArray(array $middlewares)
    {
        foreach ($middlewares as $middleware) {
            $this->callMiddleware($middleware);
        }
    }

    private function callMiddleware(string $middlewares)
    {
        call_user_func_array([$middlewares, 'start'], []);
    }
}
