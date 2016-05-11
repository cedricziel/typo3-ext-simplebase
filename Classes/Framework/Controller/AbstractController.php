<?php

namespace CedricZiel\Simplebase\Framework\Controller;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @package CedricZiel\Simplebase\Framework\Controller
 */
abstract class AbstractController implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @param string $service
     * @param int    $onInvalid
     *
     * @return object
     */
    protected function get($service, $onInvalid = ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE)
    {
        return $this->container->get($service, $onInvalid);
    }

    /**
     * @param string $templateName
     * @param array  $args
     *
     * @return string
     */
    protected function render($templateName, $args = [])
    {
        /** @var \Twig_Environment $twig */
        $twig = $this->get('twig');

        return $twig->render($templateName, $args);
    }
}
