<?php

namespace App;

trait MiddlewaresProvider
{
    private $middlewaresProvider = [
        'statistics' => \Middleware\Statistics::class,
    ];
}
