<?php

namespace App\Providers;

use App\Auth\Auth;
use App\Views\View;
use App\Session\Flash;
use App\Security\Csrf;
use Illuminate\Translation\Translator;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

class ViewShareServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    /**
     * @var array
     */
    protected $provides = [];

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Method will be invoked on registration of a service provider implementing
     * this interface. Provides ability for eager loading of Service Providers.
     *
     * @return void
     */
    public function boot()
    {
        $container = $this->getContainer();

        $container->get(View::class)->share([
            'config' => $container->get('config'),
            'auth' => $container->get(Auth::class),
            'flash' => $container->get(Flash::class),
            'csrf' => $container->get(Csrf::class),
            'backPath' => $container->get('request')->getReferer(),
            'translator' => $container->get(Translator::class)
        ]);
    }
}