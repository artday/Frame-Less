<?php

namespace App\Providers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use League\Container\ServiceProvider\AbstractServiceProvider;

class TranslationServiceProvider extends AbstractServiceProvider
{
    protected $provides = [Translator::class];

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

        $container->share(Translator::class, function() use ($config) {
            $loader = new FileLoader(
                new Filesystem(), $config->get('translations.path')
            );

            $translator = new Translator($loader, 'en');

            $translator->setFallback($config->get('translations.fallback'));

            return $translator;
        });
    }
}