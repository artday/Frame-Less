<?php

namespace App\Controllers\Auth;

use App\Auth\Auth;
use App\Views\View;
use App\Session\Flash;
use App\Controllers\Controller;
use App\Core\Framework\Request\ServerRequest;
use App\Core\Framework\Route\RouteCollection;
use Illuminate\Translation\Translator;

class LoginController extends Controller
{
    protected $auth;

    public function __construct(View $view, Auth $auth, RouteCollection $route, Flash $flash, Translator $translator)
    {
        parent::__construct($view, $route, $flash, $translator);
        $this->auth = $auth;
    }

    public function index(ServerRequest$request, $response)
    {
        return $this->view->render($response, 'auth/login.twig');
    }

    public function signin(ServerRequest $request, $response)
    {
        $data = $this->validate($request, [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $attempt = $this->auth->attempt($data['email'], $data['password'], isset($data['remember']));

        if (!$attempt) {

            $this->flash->error('Could not sign you in with those details.');

            return redirect($request->getUri()->getPath());
        }

        return redirect($this->route->getNamedRoute('home')->getPath());
    }
}