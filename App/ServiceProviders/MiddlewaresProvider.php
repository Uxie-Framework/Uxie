<?php

namespace ServiceProviders;

trait MiddlewaresProvider
{
    private $middlewaresProvider = [
        'statistics' => \Middleware\Statistics::class,
    ];
}
