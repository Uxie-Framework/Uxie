<?php
namespace App\Http;

class RequestDataHandler extends RequsetMethodHandler
{

    // set POST values to variables
    protected function postHandler()
    {
        $keys = array_keys($_POST);
        $values = array_values($_POST);
        for ($i = 0; $i < count($_POST); $i++) {
            $this->{$keys[$i]} = $values[$i];
        }
    }
}
