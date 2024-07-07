<?php

declare(strict_types=1);

namespace App\Actions;

use App\ActionInterface;
use App\AppEvent;
use Http\DispatchableInterface;
use Laminas\EventManager\EventManagerAwareTrait;
use Laminas\View\Model\ModelInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Template\TemplateRendererAwareInterface;
use Template\TemplateRendererAwareTrait;

abstract class InternalAbstractAction implements ActionInterface, DispatchableInterface, TemplateRendererAwareInterface
{
    use EventManagerAwareTrait;
    use TemplateRendererAwareTrait;

    private AppEvent $event;

    protected $eventIdentifier;

    protected ModelInterface $template;

    public function dispatch(ServerRequestInterface $request, ?ResponseInterface $response = null): ResponseInterface
    {
        $event = $this->getEvent();
        $event->setName(AppEvent::EVENT_DISPATCH);
        $event->setTarget($this); // resets the Target class!!!

        $result = $this->getEventManager()->triggerEventUntil(static fn($test): bool => $test instanceof ResponseInterface, $event);
        if($result->stopped()) {
            return $result->last();
        }
        return $event->getResult();
    }

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
        $this->getEventManager()->attach(AppEvent::EVENT_DISPATCH, [$this, 'onDispatch']);
    }
}
