<?php

namespace CedricZiel\Simplebase\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Routing\Loader\YamlFileLoader as YamlRouteLoader;

/**
 * @package CedricZiel\Simplebase
 */
class SimplebaseExtension extends Extension
{
    /**
     * Loads a specific configuration.
     *
     * @param array            $configs   An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $packageFileLocator = new FileLocator(__DIR__.'/../../Configuration/Framework');

        $loader = new YamlFileLoader(
            $container,
            $packageFileLocator
        );
        $loader->load('services.yml');

        $routeLoader = new YamlRouteLoader(
            $packageFileLocator
        );

        $routeLoader->load('routing.yml');
    }
}
