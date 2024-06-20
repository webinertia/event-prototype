<?php

declare(strict_types=1);

namespace App;

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\EventManager\EventManagerAwareInterface;
use Laminas\EventManager\EventManagerAwareTrait;
use Laminas\HttpHandlerRunner\Emitter\EmitterInterface;
use Laminas\ServiceManager\ServiceManager;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Template\TemplateManager;

use function array_merge;
use function array_unique;
use function compact;

final class App implements EventManagerAwareInterface
{
    use EventManagerAwareTrait;

    private AppEvent $event;

    private $defaultListeners = [
        BoardListener::class,
        MessageListener::class,
        DisplayListener::class,
        ActionListener::class,
        // todo: add custom action listener?
        TemplateManager::class,
    ];

    public function __construct(
        private ServiceManager $serviceManager,
        private ServerRequestInterface $request,
        private EmitterInterface $emitter
    ) {
        $this->event = new AppEvent();
        $this->event->setTarget($this);
        $this->event->setApp($this);
        $this->event->setRequest($this->request);
    }

    public function run()
    {
        $this->bootstrap($this->serviceManager->get('config')['listeners']);
        $this->dispatch($this->request);
    }

    private function dispatch(ServerRequestInterface $request, ?ResponseInterface $response = null)
    {
        $this->event->setName(AppEvents::Dispatch->value);
        $this->event->setRequest($request);
        $results = $this->getEventManager()->triggerEventUntil(function($returnedResponse) {
            return ($returnedResponse instanceof ResponseInterface);
        }, $this->event);

        if ($results->stopped()) {
            $this->emitter->emit($results->last());
        } else {
            $this->emitter->emit(new HtmlResponse('<b>Not Found</b>', 404));
        }
    }

    private function bootstrap(array $listeners = []): self
    {
        $eventManager = $this->getEventManager();
        $listeners    = array_unique(array_merge($this->defaultListeners, $listeners));
        // lets setup and attach our default listeners and any mod listeners for authors savy enough to use the 'listeners' key
        foreach ($listeners as $listener) {
            $this->serviceManager->get($listener)->attach($eventManager);
        }
        // setup the bootstrap event in case any mods needs to get in on the action
        $this->event->setName(AppEvents::Bootstrap->value);
        $this->event->stopPropagation(false);
        $eventManager->triggerEvent($this->event);

        return $this;
    }
}
