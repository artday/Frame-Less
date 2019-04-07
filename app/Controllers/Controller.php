<?php

namespace App\Controllers;

use App\Views\View;
use App\Session\Flash;
use Illuminate\Translation\Translator;
use Valitron\Validator;
use App\Exceptions\ValidationException;
use App\Core\Framework\Request\ServerRequest;
use App\Core\Framework\Route\RouteCollection;

abstract class Controller
{
    protected $view;
    protected $route;
    protected $flash;
    protected $translator;

    public function __construct(View $view, RouteCollection $route, Flash $flash, Translator $translator)
    {
        $this->view = $view;
        $this->route = $route;
        $this->flash = $flash;
        $this->translator = $translator;
    }

    public function flash()
    {

    }

    public function validate(ServerRequest $request, array $rules)
    {
        $validator = new Validator($request->getParsedBody());

        $validator->mapFieldsRules($rules);

        if (!$validator->validate()) {
            throw new ValidationException($request, $validator->errors());
        }

        return $request->all();
    }
}