<?php

namespace App\Controllers;

use App\Views\View;
use App\Cookie\CookieJar;
use Psr\Http\Message\ServerRequestInterface;

class HomeController
{
    protected $view;
    private $cookie;

    public function __construct(View $view, CookieJar $cookie)
    {
        $this->view = $view;
        $this->cookie = $cookie;
    }

    public function index(ServerRequestInterface $request, $response)
    {
        return $this->view->render($response, 'home.twig');
    }
}