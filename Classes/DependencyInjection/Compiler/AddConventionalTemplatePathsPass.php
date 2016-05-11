<?php

namespace CedricZiel\Simplebase\DependencyInjection\Compiler;

use Symfony\Component\Config\Resource\FileExistenceResource;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Adds additional paths to the twig template loader
 *
 * @package CedricZiel\Simplebase\Framework\DependencyInjection\Compiler
 */
class AddConventionalTemplatePathsPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition('twig')) {
            return;
        }

        $twigFilesystemLoaderDefinition = $container->getDefinition('twig.loader.filesystem');

        // register bundles as Twig namespaces
        foreach ($container->getParameter('kernel.bundles') as $bundle => $class) {
            /**
             * TODO: Register global template path like AppBundle
             */
            /**
             * $dir = $container->getParameter('kernel.root_dir').'/Resources/Private/'.$bundle.'/views';
             * if (is_dir($dir)) {
             * $this->addTwigPath($twigFilesystemLoaderDefinition, $dir, $bundle);
             * }
             * $container->addResource(new FileExistenceResource($dir));
             * */

            $reflection = new \ReflectionClass($class);
            $dir = dirname($reflection->getFileName()).'/../Resources/Private/views';
            if (is_dir($dir)) {
                $this->addTwigPath($twigFilesystemLoaderDefinition, $dir, $bundle);
            }
            $container->addResource(new FileExistenceResource($dir));
        }
    }

    private function addTwigPath($twigFilesystemLoaderDefinition, $dir, $bundle)
    {
        $name = $bundle;
        if ('Bundle' === substr($name, -6)) {
            $name = substr($name, 0, -6);
        }
        $twigFilesystemLoaderDefinition->addMethodCall('addPath', [$dir, $name]);
    }
}
