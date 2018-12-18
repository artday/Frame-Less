<?php

use App\Providers\ConfigServiceProvider;
use League\Container\Container;
use League\Container\ReflectionContainer;

use App\Providers\AppServiceProvider;
use App\Providers\ViewServiceProvider;

$container = new Container;
$container->delegate(new ReflectionContainer);

$container->addServiceProvider(AppServiceProvider::class);
$container->addServiceProvider(ViewServiceProvider::class);
$container->addServiceProvider(ConfigServiceProvider::class);