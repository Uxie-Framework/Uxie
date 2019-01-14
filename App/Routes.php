<?php

$this->get('/', function ($request, $response) {
    $response->view('index')->send();
    $response->end();
});
