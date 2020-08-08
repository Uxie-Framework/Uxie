<?php

use Request\Request as Request;
use Response\Response as Response;

$route->group('/', function($route) {
    
    $route->get('/', function (Request $request, Response $response) {
        $response->view('index');
    });

})
->middleware('csrf')
->middleware('statistics', true);
