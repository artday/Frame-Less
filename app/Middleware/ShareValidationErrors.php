<?php

namespace App\Middleware;

use App\Views\View;
use App\Session\SessionStore;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ShareValidationErrors
{
    protected $view;
    protected $session;

    public function __construct(View $view, SessionStore $session)
    {
        $this->view = $view;
        $this->session = $session;
    }
    
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $this->view->share([
            'errors' => $this->session->get('errors', []),
            'old' => $this->session->get('old', []),
        ]);
        
        return $next($request, $response);
    }
}