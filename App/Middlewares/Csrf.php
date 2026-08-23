<?php

declare(strict_types=1);

namespace Middleware;

use Request\Request as Request;
use Response\Response as Response;

class Csrf
{
    public function __construct(Request $request, Response $response)
    {
        if ($request->method() !== 'GET') {
            $body = $request->body ?? null;
            $token = ($body && isset($body->_token)) ? $body->_token : null;
            $this->validateToken($token);
        }
    }

    private function validateToken(?string $token): bool
    {
        $sessionToken = isset(container()->Session->_token) ? getSession('_token') : null;

        if ($token !== null && $sessionToken !== null && $token === $sessionToken) {
            return true;
        }

        throw new \Exception('No CSRF token detected (use csrf_field() function)', 28);
    }
}
