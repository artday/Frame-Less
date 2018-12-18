<?php

use League\Container\Container;
use League\Container\ReflectionContainer;
use App\Providers\ConfigServiceProvider;

$container = new Container;
$container->delegate(new ReflectionContainer);

$container->addServiceProvider(ConfigServiceProvider::class);

foreach ($container->get('config')->get('app.providers') as $provider) {
    $container->addServiceProvider($provider);
}