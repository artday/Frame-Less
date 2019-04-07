<?php

namespace App\Security;

use App\Session\SessionStore;

class Csrf
{
    protected $session;
    protected $persistToken = true;

    public function __construct(SessionStore $session)
    {
        $this->session = $session;
    }

    public function key()
    {
        return 'csrf-token';
    }

    public function token()
    {
        if (!$this->tokenNeedToBeGenerated()) {
            return $this->getTokenFromSession();
        }

        $this->session->set($this->key(), $token = random_string(32));
        return $token;
    }

    //TODO: check if token exist
    public function tokenIsValid($token)
    {
        //return $token === $this->session->get($this->key());
        return $token === $this->token();
    }

    protected function tokenNeedToBeGenerated()
    {
        return !$this->session->exists($this->key()) || !$this->shouldPersistToken();
    }

    protected function shouldPersistToken()
    {
        return $this->persistToken;
    }

    protected function getTokenFromSession()
    {
        return $this->session->get($this->key());
    }

}