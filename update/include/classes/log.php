<?php
namespace classes;

class log
{

	public static function query_error($error, $position)
	{
		$date = date("y-m-d H:i");
		$error = "\n# By $position # $date # $error";
		file_put_contents('include/log/query_errors.log', $error, FILE_APPEND);
	}

	public static function error($error, $code)
	{
		$date = date("y-m-d H:i");
		$error = "\n# code : $code # $date # $error";
		file_put_contents('include/log/All_errors.log', $error, FILE_APPEND);
	}

	public static function log($file,$log)
	{
		$date = date("y-m-d H:i");
		file_put_contents("include/log/$file.log", "\n$date # ".$log, FILE_APPEND);
	}

}
