<?php

declare(strict_types=1);

namespace Template\Container;

use Laminas\ServiceManager\Initializer\InitializerInterface;
use Psr\Container\ContainerInterface;
use Template\TemplateRendererAwareInterface;
use Template\TemplateRendererInterface;

final class TemplateRendererAwareInitializer implements InitializerInterface
{
    public function __invoke(ContainerInterface $container, $instance)
    {
        if (! $instance instanceof TemplateRendererAwareInterface) {
            return;
        }
        // todo: add some defense here
        $instance->setRenderer($container->get(TemplateRendererInterface::class));
        return $instance;
    }
}
