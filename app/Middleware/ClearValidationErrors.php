<?php

namespace App\Middleware;

use App\Session\SessionStore;
use Psr\Http\Message\ResponseInterface;
use App\Core\Framework\Request\ServerRequest;

class ClearValidationErrors
{
    protected $session;

    public function __construct(SessionStore $session)
    {
        $this->session = $session;
    }

    public function __invoke(ServerRequest $request, ResponseInterface $response, callable $next)
    {
        $next = $next($request, $response);
        $this->session->clear('errors', 'old');
        return $next;
    }
}