<?php

namespace App\Providers;

use App\Views\Extensions\PathExtension;
use League\Container\ServiceProvider\AbstractServiceProvider;

use App\Views\View;
use League\Route\RouteCollection;
use Twig_Environment;
use Twig_Extension_Debug;
use Twig_Loader_Filesystem;

class ViewServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        View::class
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

        $config = $container->get('config');
        $route = $container->get(RouteCollection::class);

        $container->share(View::class, function() use ($config, $route) {
            $loader = new Twig_Loader_Filesystem(base_path('views'));

            $twig = new Twig_Environment($loader, [
                'cache' => $config->get('cache.views.path'),
                'debug' => $config->get('app.debug')
            ]);

            if ($config->get('app.debug')) {
                $twig->addExtension(new Twig_Extension_Debug);
            }

            $twig->addExtension(new PathExtension($route));

            return new View($twig);
        });

    }
}