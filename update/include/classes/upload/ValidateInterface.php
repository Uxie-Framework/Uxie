<?php
namespace classes\upload;

interface ValidateInterface
{
  public function Size($AllowedSize);
  public function Extension($AllowedExtension);
  public function Exist();
}

 ?>
