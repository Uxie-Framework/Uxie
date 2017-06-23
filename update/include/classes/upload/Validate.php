<?php
namespace classes\upload;

class Validate extends FileInfo implements ValidateInterface
{

  public $Errors = array();

  function __construct($FilePath)
  {
    if (is_uploaded_file($FilePath)) {
      parent::__construct($FilePath);
    } else {
      $this->Errors[] = "Files Was Not Uploaded";
    }
  }

  public function Size($AllowedSize)
  {
    if($this->getSize() > $AllowedSize) {
      $this->Errors[] = "File size Not Allowed : ".$this->getName();
    }
    return $this;
  }

  public function Extension($AllowedExtension)
  {
    $AllowedExtension = explode(",", $AllowedExtension);
    $AllowedExtension = array_map('strtolower', $AllowedExtension);
      if (!in_array($this->getExtension(), $AllowedExtension) and $this->getExtension()) {
        $this->Errors[] = "Extension Not Allowed : ".$this->getExtension();
      }
    return $this;
  }

  public function Exist()
  {
      if (!$this->getName()) {
        $this->Errors[] = "File was Not selected";
      }
    return $this;
  }

}

 ?>
