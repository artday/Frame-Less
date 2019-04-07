<?php

/*
 * TODO: replace ServerRequestInterface with ServerRequest
 * */

namespace App\Middleware;

use App\Auth\Auth;
use Psr\Http\Message\ResponseInterface;
use App\Core\Framework\Request\ServerRequest;

class Authenticated
{
    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function __invoke(ServerRequest $request, ResponseInterface $response, callable $next)
    {
        if (!$this->auth->check()) {
            $response = redirect(route('auth.login'));
        }
        return $next($request, $response);
    }
}
