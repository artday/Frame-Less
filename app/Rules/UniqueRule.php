<?php

namespace App\Rules;

class UniqueRule
{
    public function validate($field, $value, $params, $fields)
    {
        // only Model in params - works same as exists rule
        if(count($params) == 1){
            return $params[0]::where($field, '=', $value)
                    ->first() === null;
        }

        // Model and id in params.
        if(count($params) == 2) {
            return $params[0]::where($field, '=', $value)
                    ->where('id', '<>', $params[1])
                    ->first() === null;
        }

        return false;
    }
}