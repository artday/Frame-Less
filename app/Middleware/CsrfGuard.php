<?php

namespace App\Middleware;

use App\Security\Csrf;
use App\Exceptions\CsrfTokenException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CsrfGuard
{
    protected $csrf;

    public function __construct(Csrf $csrf)
    {
        $this->csrf = $csrf;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        if (!$this->requestRequireProtection($request)) {
            return $next($request, $response);
        }

        if (!$this->csrf->tokenIsValid($this->getTokenFromRequest($request))) {
            throw new CsrfTokenException();
        }

        return $next($request, $response);
    }

    protected function requestRequireProtection(ServerRequestInterface $request)
    {
        return in_array($request->getMethod(), ['POST', 'PUT', 'DELETE', 'PATCH']);
    }

    protected function getTokenFromRequest(ServerRequestInterface $request)
    {
        $token = $request->getParsedBody()[$this->csrf->key()];
        return $token ? $token : null;
    }
}