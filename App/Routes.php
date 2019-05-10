<?php

use Request\Request as Request;
use Response\Response as Response;

$route->get('/', function (Request $request, Response $response) {
    $response->view('index');
});
