<?php

namespace App\download;

class Images extends Download
{
    private $Files = [];

    public function __construct($Link, $Target)
    {
        if (!is_dir($Target)) {
            mkdir($Target);
        }
        $this->Files = $this->getLinks($Link, '@img.*?src=[\'"](.*?)[\'"|?]@i');
        foreach ($this->Files as $File) {
            $localFile = end(explode('/', $File));
            if (!strstr($File, 'http')) {
                $File = $Link.DIRECTORY_SEPARATOR.$File;
            }
            copy($File, $Target.DIRECTORY_SEPARATOR.$localFile);
        }
    }
}
