<?php

namespace App\Views\Extensions;

use Twig_Extension;
use Twig_SimpleFunction;
use App\Core\Framework\Route\RouteCollection;

class  PathExtension extends Twig_Extension
{
    protected $route;

    public function __construct(RouteCollection $route)
    {
        $this->route = $route;
    }
    
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('route', [$this, 'route']),
            new Twig_SimpleFunction('asset', [$this, 'asset'])
        ];
    }


    //TODO: Check getPath() / does it needs incoming $args?
    public function route($name, array $args = [])
    {
        return $this->route->getNamedRoute($name)->getPath($args);
    }

    public function asset($path)
    {
        return env('APP_URL').'/public/'.$path;
    }
}