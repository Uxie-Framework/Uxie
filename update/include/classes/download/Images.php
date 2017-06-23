<?php
namespace classes\download;

class Images extends Download
{

  private $Files = array();
  private $Links = array();
  private $Link;

  function __construct($Link, $Target)
  {

    if (!is_dir($Target)) {
      mkdir($Target);
    }
    $Files = $this->getLinks($Link, '@img.*?src=[\'"](.*?)[\'"|?]@i');
    foreach ($Files as $File ) {
      $localFile = end(explode('/', $File));
      if (!strstr($File, 'http')) {
        $File = $Link.DIRECTORY_SEPARATOR.$File;
      }
      copy($File, $Target.DIRECTORY_SEPARATOR.$localFile);
    }

  }

}

 ?>
