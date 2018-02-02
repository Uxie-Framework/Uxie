<?php

namespace App;

class Log
{
    public static function queryError($error, $position)
    {
        $date = date('y-m-d H:i:s');
        $error = "\n# By $position # $date # $error";
        file_put_contents('../log/query_errors.log', $error, FILE_APPEND);
    }

    public static function error($error, $code, $line, $file)
    {
        $date = date('y-m-d H:i:s');
        $error = "\n# code : $code # $date # $error # $line # $file";
        file_put_contents('../log/All_errors.log', $error, FILE_APPEND);
    }

    public static function log($log, $file)
    {
        $date = date('y-m-d H:i:s');
        file_put_contents("../log/$file.log", "\n$date # ".$log, FILE_APPEND);
    }
}
