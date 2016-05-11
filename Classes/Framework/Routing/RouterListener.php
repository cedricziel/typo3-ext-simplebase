<?php

namespace CedricZiel\Simplebase\Framework\Routing;

use CedricZiel\Simplebase\Controller\DefaultController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Plugs into the HttpKernel and resolves the controllers
 *
 * @package CedricZiel\Simplebase\Routing
 */
class RouterListener implements EventSubscriberInterface
{
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
        $request->attributes->set('_controller', 'SimplebaseBundle:Default:index');
    }
}
