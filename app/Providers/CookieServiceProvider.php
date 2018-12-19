<?php

namespace App\Providers;

use App\Cookie\CookieJar;
use League\Container\ServiceProvider\AbstractServiceProvider;

class CookieServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        CookieJar::class
    ];

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     *
     * @return void
     */
    public function register()
    {
        $container = $this->getContainer();

        $container->share(CookieJar::class, function () {
            return new CookieJar();
        });
    }
}