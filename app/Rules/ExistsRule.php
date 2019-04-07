<?php

namespace App\Rules;

class ExistsRule
{
    public function validate($field, $value, $params, $fields)
    {
        return $params[0]::where($params[1] ? $params[1] : $field, '=', $value)->first() === null;
    }
}