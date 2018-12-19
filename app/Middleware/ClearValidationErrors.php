<?php

namespace App\Middleware;

use App\Session\SessionStore;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ClearValidationErrors
{
    protected $session;

    public function __construct(SessionStore $session)
    {
        $this->session = $session;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $next = $next($request, $response);
        $this->session->clear('errors', 'old');
        return $next;
    }
}