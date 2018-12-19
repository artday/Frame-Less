<?php

namespace App\Controllers;

use App\Views\View;
use Psr\Http\Message\ServerRequestInterface;

class DashboardController
{
    protected $view;

    public function __construct(View $view)
    {
        $this->view = $view;
    }

    public function index(ServerRequestInterface $request, $response)
    {
        return $this->view->render($response, 'dashboard/index.twig');
    }
}
