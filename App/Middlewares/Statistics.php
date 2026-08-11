<?php

declare(strict_types=1);

namespace Middleware;

use Request\Handler\Request as Request;
use Response\Response as Response;

class Statistics
{
    public function __construct(Request $request, Response $response)
    {
        container()->build('Statistics\Visit');
    }
}
