<?php

declare(strict_types=1);

namespace App;

use Http\Psr7AwareInterface;
use Http\Psr7AwareTrait;
use Laminas\EventManager\EventManagerAwareInterface;
use Laminas\EventManager\EventManagerAwareTrait;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Laminas\ServiceManager\ServiceManager;
use Psr\Http\Message\ResponseInterface;

use function array_merge;
use function array_unique;
use function class_exists;

final class App implements AppInterface, EventManagerAwareInterface, Psr7AwareInterface
{
    use EventManagerAwareTrait;
    use Psr7AwareTrait;

    private array $config;

    private $defaultListeners = [
        Listeners\NotFoundListener::class,
        Listeners\RouteListener::class, // run this here since we need to step out pre routing for the previous listeners.
        Listeners\DispatchListener::class,
        Listeners\EmitResponseListener::class,
    ];

    public function __construct(
        private ServiceLocatorInterface $serviceManager,
        private AppEvent $event = new AppEvent()
    ) {
    }

    private function bootstrap(array $listeners = []): self
    {
        $this->getConfig();
        $eventManager = $this->getEventManager();
        $listeners    = array_unique(array_merge($this->defaultListeners, $listeners));
        // lets setup and attach our default listeners and any mod listeners for authors savy enough to use the 'listeners' key
        foreach ($listeners as $listener) {
            $this->serviceManager->get($listener)->attach($eventManager);
        }

        $this->event->setTarget($this);
        $this->event->setApp($this);
        // setup the bootstrap event in case any mods needs to get in on the action
        $this->event->setName(AppEvent::EVENT_BOOTSTRAP);
        $this->event->stopPropagation(false);
        $eventManager->triggerEvent($this->event);

        return $this;
    }

    public function run()
    {
        $sm = $this->getServiceManager();
        $events = $this->getEventManager();
        $this->bootstrap($sm->get('config')['listeners']);
        $event = $this->event;

        $propagationCheck = static function($result) use($event): bool {
            // We stop propagation when we get a ResponseInterface as a return
            if ($result instanceof ResponseInterface) {
                return true;
            }
            if ($event->isError() || $event->isException()) {
                return true;
            }
            return false;
        };

        // Set Event context
        $event->setRequest($this->getRequest());
        $event->setResponse($this->getResponse());
        $event->setName(AppEvent::EVENT_ROUTE);
        $event->stopPropagation(false);
        // Trigger route event
        $result = $events->triggerEventUntil($propagationCheck, $event);
        if ($result->stopped()) {
            $response = $result->last();
            if ($response instanceof ResponseInterface) { // if we have a ResponseInterface here we had an error/exception so complete the request
                $event->setTarget($this);
                $event->setResponse($response);
                $event->setResult($response); // onEmitResponse expects the event result to be the response instance to emit
                $event->stopPropagation(false);
                return $this->completeRequest($event);
            }
        }

        // If an error or exception is encountered complete the request
        // if ($event->getError() || $event->getException()) {
        //     return $this->completeRequest($event);
        // }

        // Trigger dispatch event
        $event->setName(AppEvent::EVENT_DISPATCH);
        $event->stopPropagation(false);
        $result = $events->triggerEventUntil($propagationCheck, $event);

        return $this->completeRequest($event); // the event should have the correct state set so just pass it
    }

    public function getServiceManager(): ServiceManager
    {
        return $this->serviceManager;
    }

    protected function completeRequest(AppEvent $event): self
    {
        $events = $this->getEventManager();
        $event->setTarget($this);

        // Trigger the emit response event, actually sends the response to the client
        $event->setName(AppEvent::EVENT_EMIT_RESPONSE);
        $event->stopPropagation(false);
        $events->triggerEvent($event);
        if ($this->config['debug'] && class_exists(\Tracy\Debugger::class)) {
            $runtime = \Tracy\Debugger::timer('total-runtime');
            \Tracy\Debugger::barDump(['total-runtime' => $runtime]);
        }
        return $this;
    }

    public function getDefaultListeners(): array // for unit testing
    {
        return $this->defaultListeners;
    }

    public function getEvent(): AppEvent
    {
        return $this->event;
    }

    public function setEvent(AppEvent $event): self
    {
        $this->event = $event;
        return $this;
    }

    public function getConfig(): array
    {
        $this->config = $this->getServiceManager()->get('config');
        return $this->config;
    }
}
