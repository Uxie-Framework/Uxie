<?php

use Request\Handler\Request as Request;
use Response\Response as Response;

$route->group('/', function ($route) {
    $route->get('/', function (Request $request, Response $response): void {
        $response->view('index');
    });
})
->middleware('csrf')
->middleware('nullifyInput');
