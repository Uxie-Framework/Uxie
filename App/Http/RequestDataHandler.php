<?php

namespace App\Http;

class RequestDataHandler
{
    public function handle()
    {
        $variables = [];
        $keys = array_keys($_POST);
        $values = array_values($_POST);
        for ($i = 0; $i < count($_POST); $i++) {
            $this->{$keys[$i]} = $values[$i];
            $variables[$keys[$i]] = $values[$i];
        }

        return $variables;
    }
}
