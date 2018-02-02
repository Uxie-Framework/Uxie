<?php

namespace Middleware;

class Statistics
{
    public static function start()
    {
        container()->build('Statistics\Visit');
    }
}
