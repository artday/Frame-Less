<?php
namespace App\Controllers\Auth;

use App\Auth\Auth;
use App\Views\View;
use App\Models\User;
use App\Auth\Hashing\Hasher;
use App\Controllers\Controller;
use App\Core\Framework\Route\RouteCollection;

class RegisterController extends Controller
{
    protected $auth;
    protected $hash;
    protected $view;
    protected $route;

    public function __construct(View $view, Hasher $hash, Auth $auth, RouteCollection $route)
    {
        $this->auth = $auth;
        $this->view = $view;
        $this->hash = $hash;
        $this->route = $route;
    }

    public function index($request, $response)
    {
        return $this->view->render($response, 'auth/register.twig');
    }

    public function register($request, $response)
    {
        $data = $this->validateRegistration($request);

        $user = $this->createUser($data);

        $attempt = $this->auth->attempt($data['email'], $data['password']);

        if (!$attempt) {
            return redirect('/');
        }

        return redirect($this->route->getNamedRoute('home')->getPath());
    }

    protected function createUser($data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $this->hash->create($data['password']),
        ]);
    }

    protected function validateRegistration($request)
    {
        return $this->validate($request, [
            'email' => ['required', 'email', ['exists', User::class]],
            'name' => ['required'],
            'password' => ['required'],
            'password_confirmation' => ['required', ['equals', 'password']]
        ]);
    }
}