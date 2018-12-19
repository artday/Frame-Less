<?php

namespace App\Cookie;

class CookieJar
{
    protected $path = '/';
    protected $domain = null;
    protected $secure = false;
    protected $httpOnly = true;

    public function set($name, $value, $minutes = 60)
    {
        $expiry = time() + ($minutes * 60);
        setcookie($name, $value , $expiry, $this->path, $this->domain, $this->secure, $this->httpOnly);
    }

    public function get($name, $default = null)
    {
        return $this->exists($name) ? $_COOKIE[$name] : $default;
    }

    public function exists($name)
    {
        return isset($_COOKIE[$name]) && !empty($_COOKIE[$name]);
    }

    public function clear($name)
    {
        $this->set($name, null, -2628000);
    }

    public function forever($name, $value)
    {
        $this->set($name, $value, 2628000);
    }
}