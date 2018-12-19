<?php

namespace App\Providers;

use App\Security\Csrf;
use App\Session\SessionStore;
use League\Container\ServiceProvider\AbstractServiceProvider;

class CsrfServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        Csrf::class
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

        $container->share(Csrf::class, function () use ($container) {
            return new Csrf(
                $container->get(SessionStore::class)
            );
        });
    }
}