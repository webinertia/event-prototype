<?php

declare(strict_types=1);

namespace Template\Container;

use Laminas\EventManager\EventManagerInterface;
use Laminas\View\View;
use Laminas\View\Strategy\PhpRendererStrategy;
use Psr\Container\ContainerInterface;

final class TemplateFactory
{
    public function __invoke(ContainerInterface $container): View
    {
        $view   = new View();
        $events = $container->get(EventManagerInterface::class);
        $view->setEventManager($events);
        $container->get(PhpRendererStrategy::class)->attach($events);
        return $view;
    }
}
