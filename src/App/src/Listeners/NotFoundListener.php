<?php

declare(strict_types=1);

namespace App\Listeners;

use App\AppEvent;
use App\DispatchableInterface;
use App\DispatchableInterfaceTrait;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventManagerInterface;
use Psr\Http\Message\ResponseInterface;
use Template\TemplateAwareInterface;
use Template\TemplateAwareTrait;

use const PHP_INT_MIN;

final class NotFoundListener extends AbstractListenerAggregate implements DispatchableInterface, TemplateAwareInterface
{
    use DispatchableInterfaceTrait;
    use TemplateAwareTrait;

    private string $notFound = 'error:404';

    public function __construct (
        private array $config
    ) {
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(AppEvent::EVENT_DISPATCH, [$this, 'onDispatch'], PHP_INT_MIN);
    }

    public function onDispatch(AppEvent $event): ?ResponseInterface
    {
        $message  = $event->getError();
        $template = $this->getTemplate();
        return new HtmlResponse($template->render($this->notFound, ['message' => $message]), 404);
    }
}
