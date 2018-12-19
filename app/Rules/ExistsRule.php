<?php

namespace App\Rules;

class ExistsRule
{
    public function validate($field, $value, $params, $fields)
    {
        return $params[0]::where($field, '=', $value)->first() === null;
    }
}