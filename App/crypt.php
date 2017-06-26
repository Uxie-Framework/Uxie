<?php
namespace App;

class Crypt
{
    public static function basicCrypt(string $string)
    {
        $name = str_split($string);
        for ($i = 0; $i < count($name)-1; $i++) {
            $x = $name[$i];
            $name[$i] = $name[$i+1];
            $name[$i+1] = $x;
            $i++;
        }
        $name = implode("", $name);
        $string = $name;
        return $string;
    }

    public static function reverseBasicCrypt(string $string)
    {
        $name = str_split($string);
        for ($i = 0; $i < count($name)-1; $i++) {
            $x = $name[$i + 1];
            $name[$i+1] = $name[$i];
            $name[$i] = $x;
            $i++;
        }
        $name = implode("", $name);
        $string = $name;
        return $string;
    }

    public static function advacedCrypt(string $string)
    {
        $array_name1 = str_split($string);
        $array_name2 = array();
        for ($i=0; $i < count($array_name1); $i++) {
            $array_name2[] = $array_name1[$i];
            $i++;
        }
        $salt = implode("", $array_name2);
        $string = crypt(md5($name), $salt);
        return $string;
    }
}
