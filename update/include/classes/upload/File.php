<?php
namespace classes\upload;

class File extends Validate
{

  function __construct($key, $File = false)
  {
    if (!$File) {
      $File = array(
        'name' => $_FILES[$key]['name'],
        'tmp_name' => $_FILES[$key]['tmp_name']
      );
    }
    $FilePath = $File['tmp_name'];
    $FileName = explode(".", $File["name"]);
    $this->setName($FileName[0]);
    $this->setExtension(strtolower(end($FileName)));
    parent::__construct($FilePath);
  }

  public function Upload($newPath)
  {
    $newPath = $_SERVER["DOCUMENT_ROOT"].'/'.$newPath;
    if (is_dir($newPath) && is_writable($newPath)) {
      if (empty($this->Errors)) {
        $Path = $newPath.DIRECTORY_SEPARATOR.$this->getName().'.'.$this->getExtension();
        move_uploaded_file($this->getTmpName(), $Path);
        return array('name' => $this->getName().'.'.$this->getExtension(), 'dir' => $Path);
      } else {
        return false;
      }
    } else {
      $this->Errors[] = "No access to this directory $newPath";
      return false;
    }
  }

}
