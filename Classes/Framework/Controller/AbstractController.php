<?php

namespace CedricZiel\Simplebase\Framework\Controller;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Form;

/**
 * @package CedricZiel\Simplebase\Framework\Controller
 */
abstract class AbstractController implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * Creates and returns a Form instance from the type of the form.
     *
     * @param string $type    The fully qualified class name of the form type
     * @param mixed  $data    The initial data for the form
     * @param array  $options Options for the form
     *
     * @return Form
     */
    protected function createForm($type, $data = null, array $options = array())
    {
        return $this->container->get('form.factory')->create($type, $data, $options);
    }

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
