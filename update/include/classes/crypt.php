<?php
namespace classes;

class crypt
{

	public static function a($source)
	{
		$name = str_split($source);
		for ($i = 0; $i < count($name)-1; $i++) {
			$x = $name[$i];
			$name[$i] = $name[$i+1];
			$name[$i+1] = $x;
			$i++;
		}
		$name = implode("", $name);
		$source = $name;
		return $source;
	}

	public static function a_reverse($source)
	{
		$name = str_split($source);
		for($i = 0; $i < count($name)-1; $i++) {
			$x = $name[$i + 1];
			$name[$i+1] = $name[$i];
			$name[$i] = $x;
			$i++;
		}
		$name = implode("", $name);
		$source = $name;
		return $source;
	}
    
	public static function b($source)
	{
		$array_name1 = str_split($source);
		$array_name2 = array();
		for ($i=0; $i < count($array_name1); $i++) {
			$array_name2[] = $array_name1[$i];
			$i++;
		}
		$salt = implode("", $array_name2);
		$source = crypt(md5($name), $salt);
		return $source;
	}

}
