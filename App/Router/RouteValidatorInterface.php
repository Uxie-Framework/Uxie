<?php

namespace App\Router;

interface RouteValidatorInterface
{
    public function validate(RouteInterface $route, string $url);
}
