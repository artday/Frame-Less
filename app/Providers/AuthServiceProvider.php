<?php

namespace App\Providers;

use App\Auth\Auth;
use App\Auth\Recaller;
use App\Session\SessionStore;
use App\Cookie\CookieJar;
use App\Auth\Hashing\Hasher;
use App\Auth\Providers\DatabaseProvider;
use League\Container\ServiceProvider\AbstractServiceProvider;

class AuthServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        Auth::class
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

        $container->share(Auth::class, function () use ($container) {
            return new Auth(
                new DatabaseProvider(),
                $container->get(Hasher::class),
                $container->get(SessionStore::class),
                $container->get(CookieJar::class),
                new Recaller()
            );
        });
    }
}