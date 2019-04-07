<?php

namespace App\Session;

class Flash
{
    protected $session;
    protected $messages;

    public function __construct(SessionStore $session)
    {
        $this->session = $session;

        $this->loadFlashMessagesIntoCache();

        $this->clear();
    }

    public function now($key, $value)
    {
        $flash = $this->session->get('flash');

        $this->session->set('flash', array_merge(
            $flash ? $flash : [], [$key => $value]
        ));
    }

    public function get($key)
    {
        return $this->has($key) ? $this->messages[$key] : null;
    }

    public function has($key)
    {
        return isset($this->messages[$key]);
    }

    protected function getAll()
    {
        return $this->session->get('flash');
    }

    protected function loadFlashMessagesIntoCache()
    {
        $this->messages = $this->getAll();
    }

    protected function clear()
    {
        $this->session->clear('flash');
    }

    public function success($value)
    {
        $this->now('success', $value);
    }

    public function error($value)
    {
        $this->now('error', $value);
    }

    public function info($value)
    {
        $this->now('info', $value);
    }
    public function warning($value)
    {
        $this->now('warning', $value);
    }
}