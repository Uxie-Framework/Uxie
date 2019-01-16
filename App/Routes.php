<?php

use Request\Request as Request;
use Response\Response as Response;

$this->get('/', function (Request $request, Response $response) {
    $response->view('index');
});
