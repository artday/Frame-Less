<?php
/*
create own Route class, which extends \League\Route\RouteCollection.
Its necessary because there is dependency from Route in map() method.
Notify that we changed Route with our own.
See  App\Core\Framework\Route
*/

namespace App\Core\Framework\Route;

class RouteCollection extends \League\Route\RouteCollection
{
    public function map($method, $path, $handler)
    {
        $path = sprintf('/%s', ltrim($path, '/'));
        $route = (new Route)->setMethods((array)$method)->setPath($path)->setCallable($handler);

        $this->routes[] = $route;

        return $route;
    }

    public function group($prefix, callable $group)
    {
        $group          = new RouteGroup($prefix, $group, $this);
        $this->groups[] = $group;

        return $group;
    }
}