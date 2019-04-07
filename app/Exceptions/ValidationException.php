<?php

namespace App\Exceptions;

use Exception;
use App\Core\Framework\Request\ServerRequest;

class ValidationException extends Exception
{
    protected $request;
    protected $errors;

    public function __construct(ServerRequest $request, array $errors)
    {
        $this->request = $request;
        $this->errors = $errors;
    }

    public function getPath()
    {
//        return $this->request->getUri()->getPath();
        return $this->request->getReferer();
    }

    public function getOldInput()
    {
        return $this->request->getParsedBody();
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
