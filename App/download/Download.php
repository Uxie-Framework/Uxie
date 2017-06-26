<?php

namespace App\download;

abstract class Download
{
    protected function getLinks($Link, $Match)
    {
        $content = file_get_contents($Link);
        $Links = [];
        preg_match_all($Match, $content, $Links);

        return $Links[1];
    }
}
