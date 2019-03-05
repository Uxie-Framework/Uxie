<?php
namespace Service;

use Request\Request as Request;
use Response\Response as Response;

class Csrf
{
    private $token;

    public function __construct(Request $request, Response $response)
    {
        if ($request->method() !== 'GET') {
            $this->token = $request->body->_token ?? null;
            $this->validateToken();
        }
    }

    private function validateToken()
    {
        if (!is_null($this->token) && $this->token === session('_token')) {
            return true;
        }

        throw new \Exception("No CSRF token detected (use csrf_field() function)", 28);
    }
}
