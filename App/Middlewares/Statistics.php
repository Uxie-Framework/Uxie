<?php

namespace Middleware;

class Statistics
{
    public function __construct()
    {
        container()->build('Statistics\Visit');
    }
}
