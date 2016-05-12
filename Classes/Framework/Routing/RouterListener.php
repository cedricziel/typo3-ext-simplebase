<?php

namespace CedricZiel\Simplebase\Framework\Routing;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Router;

/**
 * Plugs into the HttpKernel and resolves the controllers
 *
 * @package CedricZiel\Simplebase\Routing
 */
class RouterListener implements EventSubscriberInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        /**
         * Examples for controller bindings:
         *
         * Using a full reference that will be __invoke'd
         * $request->attributes->set('_controller', DefaultController::class.'::indexAction');
         *
         * Using a closure:
         * $request->attributes->set('_controller', function(Request $request) {
         *   // return a ResponseInterface here
         * });
         *
         * Using the symfony fullstack bundle / controller / method -reference style:
         * $request->attributes->set('_controller', 'Simplebase:Default:index');
         *
         * ToDo: Resolve routes from the given TypoScript configuration for the USER object
         */

        $extensionName = $this->container->getParameter('extensionName');
        $pluginName = $this->container->getParameter('pluginName');

        $baseBundleName = $extensionName.'Bundle';

        $routes = $this->container->getParameter('routes');
        $prefix = $this->container->getParameter('prefix');

        var_dump($request->get($prefix, false));
        if (false !== $request->get($prefix, false) && '' !== $request->get($prefix,
                ['controller' => ''])['controller']
        ) {
            $request->attributes->set('_controller', $request->get($prefix)['controller']);
            $request->attributes->set('news', $request->get($prefix)['news']);

            return;
        }

        /**
         * @TODO: Integrate routing configuration deeper into container
         */
        $request->attributes->set('_controller', $routes[0]['_controller']);
    }
}
