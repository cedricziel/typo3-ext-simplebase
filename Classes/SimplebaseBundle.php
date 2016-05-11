<?php

namespace CedricZiel\Simplebase;

use CedricZiel\Simplebase\DependencyInjection\Compiler\AddConventionalTemplatePathsPass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\EventDispatcher\DependencyInjection\RegisterListenersPass;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * The framework bundle
 *
 * @package CedricZiel\Simplebase
 */
class SimplebaseBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AddConventionalTemplatePathsPass());
        $container->addCompilerPass(new RegisterListenersPass(), PassConfig::TYPE_BEFORE_REMOVING);
    }
}
