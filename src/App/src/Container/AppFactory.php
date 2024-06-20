<?php

declare(strict_types=1);

namespace App\Container;

use App\ActionListener;
use App\App;
use App\BoardListener;
use App\DisplayListener;
use App\MessageListener;
use Psr\Container\ContainerInterface;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\EventManager\EventManagerInterface;
use Laminas\HttpHandlerRunner\Emitter\EmitterInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;

final class AppFactory
{
    public function __invoke(ContainerInterface $container): App
    {
        /** @var ServerRequestFactory */
        $factory = $container->get(ServerRequestFactoryInterface::class);
        $app = new App(
            $container,
            $factory::fromGlobals(),
            $container->get(EmitterInterface::class)
        );
        $eventManager = $container->get(EventManagerInterface::class);
        // $boardListener = $container->get(BoardListener::class);
        // $boardListener->attach($eventManager);
        // $messageListener = $container->get(MessageListener::class);
        // $messageListener->attach($eventManager);
        // $displayListener = $container->get(DisplayListener::class);
        // $displayListener->attach($eventManager);
        // $actionListener = $container->get(ActionListener::class);
        // $actionListener->attach($eventManager);
        // This works because Application implements EventManagerAwareInterface and uses the implementing Trait
        $app->setEventManager($eventManager);
        return $app;
    }
}
