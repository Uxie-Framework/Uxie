<?php
namespace Middleware;

use Request\Request as Request;
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

    private function validateToken(string $token)
    {
        if (!is_null($token) && $token === getSession('_token')) {
            return true;
        }

        throw new \Exception("No CSRF token detected (use csrf_field() function)", 28);
    }
}
