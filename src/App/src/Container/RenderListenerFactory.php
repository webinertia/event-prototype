<?php

declare(strict_types=1);

namespace App\Container;

use App\Listeners\RenderListener;
use Psr\Container\ContainerInterface;
use Template\TemplateRendererInterface;

final class RenderListenerFactory
{
    public function __invoke(ContainerInterface $container): RenderListener
    {
        return new RenderListener($container->get(TemplateRendererInterface::class));
    }
}
