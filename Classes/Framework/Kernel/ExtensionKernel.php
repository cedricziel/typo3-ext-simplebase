<?php

namespace CedricZiel\Simplebase\Framework\Kernel;

use CedricZiel\Simplebase\SimplebaseBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
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
    protected $pluginBundles = [];

    /**
     * @var array
     */
    protected $standardBundles = [
        SimplebaseBundle::class,
        TwigBundle::class,
    ];

    /**
     * @var array
     */
    protected $pluginConfiguration = [];

    /**
     * Returns an array of bundles to register.
     *
     * @return BundleInterface[] An array of bundle instances.
     */
    public function registerBundles()
    {
        $bundles = [];

        // Add framework bundles
        foreach ($this->standardBundles as $standardBundleClassRef) {
            $bundles[] = new $standardBundleClassRef;
        }

        // Add plugin specific bundles
        foreach ($this->pluginBundles as $pluginBundleClassRef) {
            $bundles[] = new $pluginBundleClassRef;
        }

        // Add debug bundles
        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            foreach ($this->debugBundles as $debugBundleClassRef) {
                $bundles[] = new $debugBundleClassRef;
            }
        }

        return $bundles;
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
        $loader->load(__DIR__.'/../../../Configuration/Framework/config_'.$this->getEnvironment().'.yml');
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    /**
     * Identify this kernel uniquely
     *
     * @param $string
     */
    public function setName($string = 'simplebase')
    {
        $this->name = $string;
        $this->name = $this->getName();
    }

    /**
     * @param array $conf
     */
    public function setPluginConfiguration($conf = [])
    {
        $this->pluginConfiguration = $conf;
    }

    /**
     * Adds runtime configuration to the container being built.
     *
     * @param ContainerBuilder $container
     */
    public function prepareContainer(ContainerBuilder $container)
    {
        parent::prepareContainer($container);

        foreach ($this->pluginConfiguration as $param => $value) {
            $container->setParameter($param, $value);
        }
    }

    /**
     * Adds custom bundles to the kernel
     *
     * @param array $pluginBundles
     */
    public function addPluginSpecificBundles($pluginBundles = [])
    {
        $this->pluginBundles = $pluginBundles;
    }
}
