<?php
namespace classes;
class throwError
{
  function __construct($msg, $code)
  {
    log::error($msg, $code);
    functions::redirect("error.php?error=".urlencode($msg)."&code=".urlencode($code));
  }
}

 ?>
