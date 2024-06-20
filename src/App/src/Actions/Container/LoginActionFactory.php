<?php

declare(strict_types=1);

namespace App\Actions\Container;

use App\Actions\Listener\LoginListener;
use App\Actions\LoginAction;
use Laminas\EventManager\EventManagerInterface;
use Psr\Container\ContainerInterface;
use User\UserInterface;

final class LoginActionFactory
{
    public function __invoke(ContainerInterface $container): LoginAction
    {
        $eventManager = $container->get(EventManagerInterface::class);
        $loginListener = $container->get(LoginListener::class);
        $loginListener->attach($eventManager);
        $action = new LoginAction($container->get(UserInterface::class));
        $action->setEventManager($eventManager);
        return $action;
    }
}
