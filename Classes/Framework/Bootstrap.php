<?php

namespace CedricZiel\Simplebase\Framework;

use CedricZiel\Simplebase\Framework\Kernel\ExtensionKernel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * @package CedricZiel\Simplebase\Framework
 */
class Bootstrap
{
    /**
     * @param string $content
     * @param array $configuration
     *
     * @return string
     */
    public function run($content, $configuration)
    {
        $extensionName = $configuration['extensionName'];
        $pluginName = $configuration['pluginName'];
        $vendorName = $configuration['vendorName'];
        $configuration['prefix'] = $this->generateQueryPrefix($extensionName, $pluginName);
        $configuration['routes'] = $this->getPluginRoutes($extensionName, $pluginName);

        $kernelName = $this->generateKernelName($configuration, $vendorName, $extensionName, $pluginName);

        /** @var ExtensionKernel $kernel */
        $kernel = $this->initializeKernel($kernelName);
        $kernel->setPluginConfiguration($configuration);
        $kernel->addPluginSpecificBundles($this->getPluginSpecificBundles($extensionName, $pluginName));

        // Boot the kernel so the container is built
        $kernel->boot();

        $request = Request::createFromGlobals();
        $response = $kernel->handle($request, KernelInterface::SUB_REQUEST);

        $content = $response->getContent();
        $kernel->shutdown();

        // TODO: consider shared kernels that are terminated through register_shutdown or an outer signal
        return $content;
    }

    /**
     * Creates a kernel for the current plugin
     *
     * @param string $kernelName
     *
     * @return KernelInterface
     */
    protected function initializeKernel($kernelName = '')
    {
        $extensionKernel = new ExtensionKernel('dev', true);

        if ($kernelName !== '') {
            $extensionKernel->setName($kernelName);
        }

        return $extensionKernel;
    }

    /**
     * @param string $extensionName
     * @param string $pluginName
     * @return array
     */
    protected function getPluginSpecificBundles($extensionName, $pluginName)
    {
        $extensionConf = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['simplebase']['extensions'];

        if (false === is_array($extensionConf[$extensionName]['plugins'][$pluginName]['bundles'])) {
            return [];
        }

        return $extensionConf[$extensionName]['plugins'][$pluginName]['bundles'];
    }

    /**
     * @param string $extensionName
     * @param string $pluginName
     * @return array
     */
    protected function getPluginRoutes($extensionName, $pluginName)
    {
        $extensionConf = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['simplebase']['extensions'];

        if (false === is_array($extensionConf[$extensionName]['plugins'][$pluginName]['controllers'])) {
            return [];
        }

        return $extensionConf[$extensionName]['plugins'][$pluginName]['controllers'];
    }

    /**
     * @param $configuration
     * @param $vendorName
     * @param $extensionName
     * @param $pluginName
     * @return string
     */
    protected function generateKernelName($configuration, $vendorName, $extensionName, $pluginName)
    {
        return $vendorName.$extensionName.$pluginName.sha1(serialize($configuration));
    }

    /**
     * @param $extensionName
     * @param $pluginName
     * @return mixed
     */
    protected function generateQueryPrefix($extensionName, $pluginName)
    {
        return strtolower('tx_'.str_replace('_', '', $extensionName).'_'.str_replace('_', '',
                $pluginName));
    }
}
