<?php

declare(strict_types=1);

namespace Template\Container;

use Laminas\ServiceManager\Initializer\InitializerInterface;
use Psr\Container\ContainerInterface;
use Template\TemplateAwareInterface;
use Template\TemplateRendererInterface;

final class TemplateAwareInitializer implements InitializerInterface
{
    public function __invoke(ContainerInterface $container, $instance)
    {
        if (! $instance instanceof TemplateAwareInterface) {
            return;
        }
        // todo: add some defense here
        $instance->setTemplate($container->get(TemplateRendererInterface::class));
        return $instance;
    }
}
