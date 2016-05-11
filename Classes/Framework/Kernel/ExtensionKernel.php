<?php

namespace CedricZiel\Simplebase\Framework\Kernel;

use CedricZiel\Simplebase\SimplebaseBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel;

/**
 * @package CedricZiel\Simplebase\Framework\Kernel
 */
class ExtensionKernel extends Kernel
{
    /**
     * @var array
     */
    protected $debugBundles = [];

    /**
     * @var array
     */
    protected $normalBundles = [];

    /**
     * Returns an array of bundles to register.
     *
     * @return BundleInterface[] An array of bundle instances.
     */
    public function registerBundles()
    {
        return [
            new SimplebaseBundle(),
        ];
    }

    /**
     * @return string
     */
    public function getCacheDir()
    {
        return PATH_site.'/typo3temp/var/Cache/Simplebase';
    }

    /**
     * @return string
     */
    public function getLogDir()
    {
        return PATH_site.'/typo3temp/var/logs';
    }

    /**
     * Loads the container configuration.
     *
     * @param LoaderInterface $loader A LoaderInterface instance
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        // TODO: Implement registerContainerConfiguration() method.
    }

    public function getRootDir()
    {
        return __DIR__;
    }
}