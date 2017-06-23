<?php
namespace classes\download;

abstract class Download
{

    protected function getLinks($Link, $Match)
    {
		$content = file_get_contents($Link);
		$Links = array();
		preg_match_all($Match, $content, $Links);
		return $Links[1];
    }

}

 ?>
