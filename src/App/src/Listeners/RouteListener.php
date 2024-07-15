<?php

declare(strict_types=1);

namespace App\Listeners;

use App\App;
use App\AppEvent;
use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventManagerInterface;
use Router\RouteResult;
use Router\RouteStack;

final class RouteListener extends AbstractListenerAggregate
{
    public function __construct(
        private RouteStack $router
    ) {
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(AppEvent::EVENT_ROUTE, [$this, 'onRoute']);
    }

    public function onRoute(AppEvent $event)
    {
        $request     = $event->getRequest();
        $routeResult = $this->router->match($request);
        if ($routeResult instanceof RouteResult) {
            $event->setRouteResult($routeResult);
            return $routeResult;
        }

        // todo: wire a listener for this event
        $event->setName(AppEvent::EVENT_DISPATCH_ERROR);
        $event->setError(App::ERROR_ROUTER_NO_MATCH);
        $target = $event->getTarget();
        $results = $target->getEventManager()->triggerEvent($event);
        if (! empty($results)) {
            return $results->last();
        }

        return $event->getParams();
    }

}
