<?php

namespace App\http;

class Request extends RequestDataHandler
{
    public function __construct()
    {
        $this->dataHandler(new RequestDataHandler());
    }

    private function dataHandler(RequestDataHandler $handler)
    {
        $handler->handle();
    }
}
