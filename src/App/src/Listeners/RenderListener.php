<?php

declare(strict_types=1);

namespace App\Listeners;

use App\AppEvent;
use Laminas\Diactoros\Response;
use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventManagerInterface;
use Laminas\View\Model;
use Template\TemplateRendererInterface;

final class RenderListener extends AbstractListenerAggregate
{
    public function __construct(
        private TemplateRendererInterface $templateRendererInterface
    ) {
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(AppEvent::EVENT_RENDER, [$this, 'onRender'], $priority);
    }

    public function onRender(AppEvent $event)
    {
        // todo: improve this so that rendering can be skipped if a Response instance is returned, it would just pass through to the emitter
        $model = $event->getResult();
        $response = match(true) {
            $model instanceof Model\JsonModel => new Response\JsonResponse($this->templateRendererInterface->render($model->getTemplate(), $model)),
            $model instanceof Model\FeedModel => new Response\XmlResponse($this->templateRendererInterface->render($model->getTemplate(), $model)),
            default => new Response\HtmlResponse($this->templateRendererInterface->render($model->getTemplate(), $model)),
        };

        // modify the response to be emitted
        $event->setResponse($response);
    }
}
