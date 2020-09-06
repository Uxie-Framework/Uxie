<?php

namespace Middleware;

use Request\Request as Request;
use Response\Response as Response;

class NullifyInput
{
    private $response;
    private $request;

    public function __construct(Request $request, Response $response)
    {
        $this->response = $response;
        $this->request  = $request;
    }

    private function nullify()
    {
        foreach ($this->request->params->getArray() as $key => $value) {
            $value = trim($value);
            if ($value === '') {
                container()->request->params->$key = null;
            }
        }
    }
}
