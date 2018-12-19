<?php

use League\Container\Container;
use App\Providers\ConfigServiceProvider;
use League\Container\ReflectionContainer;

$container = new Container;
$container->delegate(new ReflectionContainer);

$container->addServiceProvider(ConfigServiceProvider::class);

foreach ($container->get('config')->get('app.providers') as $provider) {
    $container->addServiceProvider($provider);
}