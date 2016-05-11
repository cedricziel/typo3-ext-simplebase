<?php

namespace CedricZiel\Simplebase\Framework;

use CedricZiel\Simplebase\DependencyInjection\SimplebaseExtension;
use CedricZiel\Simplebase\Framework\Container\ContainerBuilder;
use CedricZiel\Simplebase\Framework\Kernel\ExtensionKernel;
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
        $kernel = $this->initializeKernel();

        $request = Request::createFromGlobals();
        $response = $kernel->handle($request);

        $content = $response->getContent();
        $kernel->shutdown();

        // TODO: consider shared kernels that are terminated through
        // register_shutdown or an outer signal
        return $content;
    }

    /**
     * Creates a kernel for the current plugin
     *
     * @return KernelInterface
     */
    protected function initializeKernel()
    {
        return new ExtensionKernel('dev', true);
    }
}
