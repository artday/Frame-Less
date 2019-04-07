<?php

namespace App\Core\Framework\Route;

class RouteGroup extends \League\Route\RouteGroup
{
    use RouteCollectionResourceTrait;

    public function __construct($prefix, callable $callback, RouteCollection $collection)
    {
        parent::__construct($prefix, $callback, $collection);
    }
}