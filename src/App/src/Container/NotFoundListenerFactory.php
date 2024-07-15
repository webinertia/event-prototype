<?php

declare(strict_types=1);

namespace App\Container;

use App\Listeners\NotFoundListener;
use Psr\Container\ContainerInterface;
use Template\TemplateRendererInterface;

final class NotFoundListenerFactory
{
    public function __invoke(ContainerInterface $container): NotFoundListener
    {
        $listener = new NotFoundListener($container->get('config'));
        $listener->setRenderer($container->get(TemplateRendererInterface::class));
        return $listener;
    }
}
