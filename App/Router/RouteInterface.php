<?php

namespace App\Router;

use App\Http\Request;

interface RouteInterface
{
    public function __construct(string $method, string $route, $action);
    public function getRoute();
    public function getVariables();
    public function getMethod();
    public function getAction();
    public function setVariablesValues(array $values);
    public function setRequest(Request $request);
}
