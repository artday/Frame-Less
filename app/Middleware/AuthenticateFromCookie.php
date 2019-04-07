<?php

namespace App\Middleware;

use Exception;
use App\Auth\Auth;
use Psr\Http\Message\ResponseInterface;
use App\Core\Framework\Request\ServerRequest;

class AuthenticateFromCookie
{
    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function __invoke(ServerRequest $request, ResponseInterface $response, callable $next)
    {
        if ($this->auth->check()) {
            return $next($request, $response);
        }

        if ($this->auth->hasRecaller()) {
            try {
                $this->auth->setUserFromCookie();
            } catch (Exception $e) {
                $this->auth->logout();
            }
        }
        return $next($request, $response);
    }
}