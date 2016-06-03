<?php

namespace CedricZiel\Simplebase\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * @package CedricZiel\Simplebase
 */
class SimplebaseExtension extends Extension
{
    /**
     * Loads a specific configuration.
     *
     * @param array $configs An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $packageFileLocator = new FileLocator(__DIR__.'/../../Configuration/Framework');

        $xmlLoader = new XmlFileLoader($container, $packageFileLocator);
        $xmlLoader->load('form.xml');
        $xmlLoader->load('validator.xml');
        $xmlLoader->load('property_access.xml');
        $xmlLoader->load('translation.xml');
        $xmlLoader->load('services.xml');

        $yamlFileLoader = new YamlFileLoader($container, $packageFileLocator);
        $yamlFileLoader->load('services.yml');
    }
}
