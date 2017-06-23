<?php
namespace App;

class validate
{
    public static function length($name, $min, $max)
    {
        $length = strlen($name);
        if ($length < $min || $length > $max) {
            return false;
        } else {
            return true;
        }
    }
}
