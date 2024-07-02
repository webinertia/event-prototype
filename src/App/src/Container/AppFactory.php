<?php

declare(strict_types=1);

namespace App\Container;

use App\App;
use Psr\Container\ContainerInterface;
use Laminas\EventManager\EventManagerInterface;
use Laminas\HttpHandlerRunner\Emitter\EmitterInterface;

final class AppFactory
{
    public function __invoke(ContainerInterface $container): App
    {
        $app = new App(
            serviceManager: $container
        );
        $eventManager = $container->get(EventManagerInterface::class);
        $app->setEventManager($eventManager);
        return $app;
    }
}
