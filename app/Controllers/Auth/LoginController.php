<?php

namespace App\Controllers\Auth;

use App\Auth\Auth;
use App\Views\View;
use App\Session\Flash;
use App\Controllers\Controller;
use League\Route\RouteCollection;
use Psr\Http\Message\ServerRequestInterface;

class LoginController extends Controller
{
    protected $auth;
    protected $view;
    protected $route;
    protected $flash;

    public function __construct(View $view, Auth $auth, RouteCollection $route, Flash $flash)
    {
        $this->auth = $auth;
        $this->view = $view;
        $this->route = $route;
        $this->route = $route;
        $this->flash = $flash;
    }

    public function index($request, $response)
    {
        return $this->view->render($response, 'auth/login.twig');
    }

    public function signin(ServerRequestInterface $request, $response)
    {
        $data = $this->validate($request, [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $attempt = $this->auth->attempt($data['email'], $data['password'], isset($data['remember']));

        if (!$attempt) {

            $this->flash->now('error', 'Could not sign you in with those details.');

            return redirect($request->getUri()->getPath());
        }

        return redirect($this->route->getNamedRoute('home')->getPath());
    }
}