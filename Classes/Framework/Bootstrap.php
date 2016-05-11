<?php

namespace CedricZiel\Simplebase\Framework;

use CedricZiel\Simplebase\DependencyInjection\SimplebaseExtension;
use CedricZiel\Simplebase\Framework\Container\ContainerBuilder;
use CedricZiel\Simplebase\Framework\Kernel\ExtensionKernel;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder as SymfonyContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * @package CedricZiel\Simplebase\Framework
 */
class Bootstrap
{
    /**
     * @param string $content
     * @param array  $configuration
     *
     * @return string
     */
    public function run($content, $configuration)
    {
        $extensionName = $configuration['extensionName'];
        $pluginName = $configuration['pluginName'];
        $vendorName = $configuration['vendorName'];

        /** @var ExtensionKernel $kernel */
        $kernel = $this->initializeKernel($vendorName.$extensionName.$pluginName);
        $kernel->setPluginConfiguration($configuration);

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
}
