<?php

declare(strict_types=1);

namespace Middleware;

use Request\Handler\Request as Request;
use Response\Response as Response;

class Csrf
{
    public function __construct(Request $request, Response $response)
    {
        if ($request->method() !== 'GET') {
            $token = $request->body->_token ?? null;
            $this->validateToken($token);
        }
    }

    private function validateToken(?string $token): bool
    {
        if ($token !== null && $token === getSession('_token')) {
            return true;
        }

        throw new \Exception('No CSRF token detected (use csrf_field() function)', 28);
    }
}
