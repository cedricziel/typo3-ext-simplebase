<?php

namespace CedricZiel\Simplebase\Framework\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolver as BaseControllerResolver;

/**
 * Note: copied from the original FrameworkBundle. Must consider requiring the bundle instead.
 *
 * @package CedricZiel\Simplebase\Framework\Controller
 */
class ControllerResolver extends BaseControllerResolver
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var ControllerNameParser
     */
    protected $parser;

    /**
     * Constructor.
     *
     * @param ContainerInterface   $container A ContainerInterface instance
     * @param ControllerNameParser $parser    A ControllerNameParser instance
     * @param LoggerInterface      $logger    A LoggerInterface instance
     */
    public function __construct(ContainerInterface $container, ControllerNameParser $parser, LoggerInterface $logger = null)
    {
        $this->container = $container;
        $this->parser = $parser;
        parent::__construct($logger);
    }

    /**
     * Returns a callable for the given controller.
     *
     * @param string $controller A Controller string
     *
     * @return mixed A PHP callable
     *
     * @throws \LogicException           When the name could not be parsed
     * @throws \InvalidArgumentException When the controller class does not exist
     */
    protected function createController($controller)
    {
        if (false === strpos($controller, '::')) {
            $count = substr_count($controller, ':');
            if (2 == $count) {
                // controller in the a:b:c notation then
                $controller = $this->parser->parse($controller);
            } elseif (1 == $count) {
                // controller in the service:method notation
                list($service, $method) = explode(':', $controller, 2);
                return array($this->container->get($service), $method);
            } elseif ($this->container->has($controller) && method_exists($service = $this->container->get($controller), '__invoke')) {
                return $service;
            } else {
                throw new \LogicException(sprintf('Unable to parse the controller name "%s".', $controller));
            }
        }
        return parent::createController($controller);
    }

    /**
     * {@inheritdoc}
     */
    protected function instantiateController($class)
    {
        if ($this->container->has($class)) {
            return $this->container->get($class);
        }
        $controller = parent::instantiateController($class);
        if ($controller instanceof ContainerAwareInterface) {
            $controller->setContainer($this->container);
        }
        return $controller;
    }
}
