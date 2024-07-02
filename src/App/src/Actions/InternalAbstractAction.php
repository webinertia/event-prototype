<?php

declare(strict_types=1);

namespace App\Actions;

use App\ActionAwareInterface;
use App\ActionAwareTrait;
use App\ActionInterface;
use App\AppEvent;
use App\Listeners\DispatchListener;
use Http\DispatchableInterface;
use Laminas\EventManager\EventManagerAwareInterface;
use Laminas\EventManager\EventManagerAwareTrait;
use Laminas\EventManager\EventManagerInterface;
use Laminas\View\Model\ModelInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Template\TemplateAwareInterface;
use Template\TemplateAwareTrait;

abstract class InternalAbstractAction implements ActionInterface, DispatchableInterface, TemplateAwareInterface
{
    use EventManagerAwareTrait;
    use TemplateAwareTrait;

    private AppEvent $event;

    abstract public function onDispatch(AppEvent $event);

    public function dispatch(ServerRequestInterface $request, ?ResponseInterface $response = null)
    {
        $event = $this->getEvent();
        $event->setName(AppEvent::EVENT_DISPATCH);
        $event->setTarget($this); // resets the Target class!!!

        $result = $this->getEventManager()->triggerEventUntil(static fn($test): bool => $test instanceof ModelInterface, $event);
        if($result->stopped()) {
            return $result->last();
        }
        return $event->getResult();
    }

    // public function setEventManager(EventManagerInterface $events)
    // {
    //     $this->eventManager = $events;
    //     $events->setIdentifiers(
    //         [$this::class, static::class]
    //     );
    // }

    public function setEvent(AppEvent $event): void
    {
        $this->event = $event;
    }

    public function getEvent(): ?AppEvent
    {
        return $this->event;
    }

    final protected function attachDefaultListeners(): void
    {
        //$events = $this->getEventManager();
        //$events->detach(DispatchListener::class, 'onDispatch');
        $this->getEventManager()->attach(AppEvent::EVENT_DISPATCH, [$this, 'onDispatch']);
    }
}
