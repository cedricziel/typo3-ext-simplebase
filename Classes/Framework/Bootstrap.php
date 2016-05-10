<?php

namespace CedricZiel\Simplebase\Framework;

use CedricZiel\Simplebase\SimplebaseSimplebaseExtension;
use CedricZiel\SimplebaseNews\Entity\News;
use Symfony\Component\DependencyInjection\ContainerBuilder as SymfonyContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use TYPO3\Doctrine\ORM\Framework\Container\ContainerBuilder;

/**
 * @package CedricZiel\Simplebase\Framework
 */
class Bootstrap
{
    /**
     * @param string $content
     * @param array $configuration
     * @return string
     */
    public function run($content, $configuration)
    {
        $container = $this->initializeContainer($configuration);
        $entityManager = $container->get('entity_manager');
        $repository = $entityManager->getRepository(News::class);
        $cat = $repository->findAll();

        var_dump($cat);

        return $content;
    }

    /**
     * Initializes the container
     *
     * @param array $configuration
     *
     * @return SymfonyContainerBuilder
     */
    public function initializeContainer($configuration = [])
    {
        $container = ContainerBuilder::build();
        $extensionReferences = $this->getPluginExtensions($configuration);

        foreach ($extensionReferences as $idx => $classReference) {
            /** @var ExtensionInterface $extension */
            $extension = new $classReference;
            $container->registerExtension($extension);
            $container->loadFromExtension($extension->getAlias());
        }

        $container->compile();

        return $container;
    }

    /**
     * Retrieve DI extensions from global configuration
     *
     * @param array $configuration
     *
     * @return array
     */
    private function getPluginExtensions($configuration = [])
    {
        // Register standard services
        $extensions = [
            SimplebaseSimplebaseExtension::class,
        ];

        $extensionName = $configuration['extensionName'];
        $globalExtensionConf = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['simplebase']['extensions'];
        $pluginName = $configuration['pluginName'];

        if (is_array($globalExtensionConf[$extensionName]['plugins'][$pluginName]['extensions'])) {
            $extensions = array_merge(
                $extensions,
                $globalExtensionConf[$extensionName]['plugins'][$pluginName]['extensions']
            );
        }

        return $extensions;
    }
}
