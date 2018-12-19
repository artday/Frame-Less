<?php

namespace App\Auth;

class Recaller
{
    protected $separator = '|';

    public function generate()
    {
        return [
            $this->generateIdentifier(),
            $this->generateToken()
        ];
    }

    public function generateValueForCookie($identifier, $token)
    {
        return $identifier . $this->separator . $token;
    }

    public function getTokenHashForDatabase($token)
    {
        return hash('sha256', $token);
    }

    public function splitCookieValue($value)
    {
        return explode($this->separator, $value);
    }

    public function validateToken($plain_token, $hashed_token)
    {
        return $this->getTokenHashForDatabase($plain_token) === $hashed_token;
    }

    protected function generateIdentifier()
    {
        return random_string();
    }

    protected function generateToken()
    {
        return random_string(64);
    }
}