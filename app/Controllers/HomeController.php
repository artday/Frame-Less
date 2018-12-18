<?php

namespace App\Controllers;

use Zend\Diactoros\Request;
use Zend\Diactoros\Response;

class HomeController
{
    public function __construct()
    {
    }

    public function index(Request $request, Response $response)
    {
        $response->getBody()->write('Home');
        return $response;
    }
}