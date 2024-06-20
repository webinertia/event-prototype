<?php

declare(strict_types=1);

namespace App\Container;

use App\ActionAwareInterface;
use App\ActionInterface;
use Laminas\ServiceManager\Initializer\InitializerInterface;
use Psr\Container\ContainerInterface;

final class ActionAwareInitializer implements InitializerInterface
{

    public function __invoke(ContainerInterface $container, $instance)
    {
        if (! $instance instanceof ActionAwareInterface) {
            return;
        }
        // todo: add some defense here
        $actionArray = $container->get('config')[ActionInterface::class];
        $instance->setActions($actionArray);
        return $instance;
    }
}
