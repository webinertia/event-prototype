<?php

declare(strict_types=1);

namespace App\Listeners;

use App\AppEvent;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventManagerInterface;
use Psr\Http\Message\ResponseInterface;
use Template\TemplateRendererAwareInterface;
use Template\TemplateRendererAwareTrait;

use const PHP_INT_MIN;

final class NotFoundListener extends AbstractListenerAggregate implements TemplateRendererAwareInterface
{
    use TemplateRendererAwareTrait;

    private string $notFound = 'error:404';

    public function __construct (
        private array $config
    ) {
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        // attach at the lowest possible priority to allow other listeners to intervene
        $this->listeners[] = $events->attach(AppEvent::EVENT_DISPATCH_ERROR, [$this, 'onDispatch'], PHP_INT_MIN);
    }

    public function onDispatch(AppEvent $event): ?ResponseInterface
    {
        $message  = $event->getError();
        $template = $this->getRenderer();
        return new HtmlResponse($template->render($this->notFound, ['message' => $message]), 404);
    }
}
