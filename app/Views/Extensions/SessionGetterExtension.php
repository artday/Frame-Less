<?php

namespace App\Views\Extensions;

use Twig_Extension;
use Twig_SimpleFunction;
use App\Session\SessionStore;

class  SessionGetterExtension extends Twig_Extension
{
    protected $session;

    public function __construct(SessionStore $session)
    {
        $this->session = $session;
    }
    
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('old', [$this, 'old'])
        ];
    }

    public function old($key, $default = null)
    {
        $old = $this->session->get('old')[$key];
        return $old ? $old : $default;
    }
}