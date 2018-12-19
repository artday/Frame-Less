<?php

namespace App\Middleware;

use App\Auth\Auth;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Guest
{
    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        if ($this->auth->check()) {
            $response = redirect('/');
        }

        return $next($request, $response);
    }
}
