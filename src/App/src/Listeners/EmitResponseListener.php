<?php

declare(strict_types=1);

namespace App\Listeners;

use App\AppEvent;
use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventManagerInterface;
use Laminas\HttpHandlerRunner\Emitter\EmitterInterface;
use Psr\Http\Message\ResponseInterface;

final class EmitResponseListener extends AbstractListenerAggregate
{
    public function __construct(
        private EmitterInterface $emitter
    ) {
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(AppEvent::EVENT_EMIT_RESPONSE, [$this, 'onEmitResponse'], -10000);
    }

    public function onEmitResponse(AppEvent $event)
    {
        /** @var ResponseInterface */
        $response = $event->getResponse();
        $this->emitter->emit($response);
    }
}
