<?php
namespace Middleware;

use Request\Request as Request;
use Response\Response as Response;

class Statistics
{
    public function __construct(Request $request, Response $response)
    {
        container()->build('Statistics\Visit');
    }
}
