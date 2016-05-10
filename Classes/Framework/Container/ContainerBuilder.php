<?php

namespace CedricZiel\Simplebase\Framework\Container;

use Symfony\Component\DependencyInjection\ContainerBuilder as SymfonyContainerBuilder;
use Symfony\Component\DependencyInjection\Tests\ContainerBuilderTest;

/**
 * @package TYPO3\Doctrine\ORM\Framework\Container
 */
class ContainerBuilder
{
    /**
     * @return array
     */
    public function getEnabledExtensions()
    {
        return [
            'simplebase',
        ];
    }

    /**
     * @param string $env
     * @return SymfonyContainerBuilder
     */
    public static function build($env = 'dev')
    {
        $container = new SymfonyContainerBuilder();

        return $container;
    }
}
