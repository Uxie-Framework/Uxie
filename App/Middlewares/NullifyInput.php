<?php

declare(strict_types=1);

namespace Middleware;

use Request\Request as Request;
use Response\Response as Response;

class NullifyInput
{
    private Response $response;
    private Request $request;

    public function __construct(Request $request, Response $response)
    {
        $this->response = $response;
        $this->request = $request;
        $this->nullify();
    }

    private function nullify(): void
    {
        foreach ($this->request->params->getArray() as $key => $value) {
            if (trim((string) $value) === '') {
                $this->request->params->$key = null;
            }
        }
    }
}
