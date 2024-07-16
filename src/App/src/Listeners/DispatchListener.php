<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Actions\ActionManager;
use App\AppEvent;
use App\AppInterface;
use App\ContextInterface;
use Exception;
use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventManagerInterface;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Laminas\Stdlib\ArrayUtils;
use Laminas\View\Model\ModelInterface;
use Psr\Http\Message\ResponseInterface;
use Router\RouteResult;
use Throwable;

use function is_object;

final class DispatchListener extends AbstractListenerAggregate
{
    private EventManagerInterface $events;
    public function __construct(
        private ActionManager $actionManager
    ) {
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->events = $events;
        $this->listeners[] = $events->attach(AppEvent::EVENT_DISPATCH, [$this, 'onDispatch']);
    }

    public function onDispatch(AppEvent $event)
    {
        // Since were here detach this or we just keep coming back over and over again..
        $this->events->detach([$this, 'onDispatch'], $event::EVENT_DISPATCH);
        if (null !== $event->getResult()) { // todo: track this down.
            return;
        }
        /** @var ServerRequest */
        $request = $event->getParam('request');
        $app         = $event->getApp();
        $routeResult = $event->getRouteResult();
        $actionClass = $routeResult instanceof RouteResult
                ? $routeResult->getParam('actionClass', 'not-found')
                : 'not-found';

        if (! $this->actionManager->has($actionClass)) {
            // marshal not found action
            $return = $this->marshalActionNotFoundEvent(
                $app::ERROR_ACTION_NOT_FOUND,
                $actionClass,
                $event,
                $app
            );
        }

        try {
            // get the action instance from the manager
            $action = $this->actionManager->get($actionClass);
            // set the actions event instance
            $action->setEvent($event);
        } catch (Throwable|ServiceNotFoundException $ex) {
            $event->setException($ex);
            $return = $this->marshalActionNotFoundEvent(
                $app::ERROR_ACTION_INVALID,
                $actionClass,
                $event,
                $app,
                $ex
            );
        }

        $request = $event->getRequest();
        $response = $event->getResponse();
        $caughtException = null;

        try {
            // dispatch the action
            $return = $action->dispatch($request, $response);
        } catch (Throwable|Exception $ex) {
            $caughtException = $ex;
        }

        if ($caughtException !== null) {
            // for the moment just throw this so we can see it
            // todo finish this so we do not have to throw the exception here
            throw $caughtException;
            $event->setName(AppEvent::EVENT_DISPATCH_ERROR);
            $event->setException($caughtException);
            $return = $app->getEventManager()->triggerEvent($event)->last();
            if (! $return) {
                $return = $event->getResult();
            }
        }
        return $this->completeDispatch($return, $event);
    }

    protected function marshalActionNotFoundEvent(
        string $type,
        string $actionName,
        AppEvent $event,
        AppInterface $app,
        $exception = null
    ) {
        $event->setName(AppEvent::EVENT_DISPATCH_ERROR);
        if ($exception !== null) {
            $event->setException($exception);
        } else {
           //$event->setError();
        }
    }

    protected function completeDispatch(?ResponseInterface $return, AppEvent $event)
    {
        $request = $event->getRequest();
        // if (! $return instanceof ModelInterface) {

        //     $model = $event->getTemplate();

        //     if (ArrayUtils::hasStringKeys($return)) {
        //         $container = $request->getAttribute(ContextInterface::class);
        //         $container = $container->merge($return);
        //         $request   = $request->withAttribute(ContextInterface::class, $container);
        //         $event->setRequest($request);
        //     }
        //     $model->setVariables($container->mergeFortemplate($return));
        //     $event->setResult($model);
        //     return $model;
        // }
        $event->setResult($return);
        return $return;
    }
}
