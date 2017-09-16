<?php

namespace App\download;

class Links extends Download
{
    private $Files = [];

    public function __construct($Link, $Target)
    {
        if (!is_dir($Target)) {
            mkdir($Target);
        }
        $this->Files = $this->getLinks($Link, "@href=[\"'](.*?)[\"']@");
        foreach ($this->Files as $File) {
            $str = str_split($File);
            if (($str[0] != '/') && (end($str) == '/') && ($this->isDirectory($File))) {
                self::__construct($Link.'/'.$File, $Target.DIRECTORY_SEPARATOR.$File);
            } elseif ($str[0] != '/') {
                $Path = $Link.DIRECTORY_SEPARATOR.$File;
                copy($Path, $Target.DIRECTORY_SEPARATOR.$File);
            }
        }
    }

    private function isDirectory($link)
    {
        $array = str_split($link);
        if (end($array) == '/') {
            return true;
        } else {
            return false;
        }
    }
}
