<?php

namespace App\Middleware;

use App\Auth\Auth;
use Psr\Http\Message\ResponseInterface;
use App\Core\Framework\Request\ServerRequest;

class Guest
{
    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function __invoke(ServerRequest $request, ResponseInterface $response, callable $next)
    {
        if ($this->auth->check()) {
            $response = redirect('/');
        }

        return $next($request, $response);
    }
}
