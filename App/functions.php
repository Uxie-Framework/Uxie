<?php

namespace App;

class functions
{
    public static function getExtension(string $name)
    {
        $name_array = explode('.', $name);
        $extention = strtolower(end($name_array));

        return $extention;
    }

    public static function redirect(string $link)
    {
        ob_start();
        header('LOCATION: '.$link);
    }
}
