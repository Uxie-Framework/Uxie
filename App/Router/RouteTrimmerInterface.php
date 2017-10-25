<?php

namespace App\Router;

interface RouteTrimmerInterface
{
    public function trim(string $route);
    public function getRealRoute();
    public function getVariablesNames();
}
