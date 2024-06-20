<?php

declare(strict_types=1);

namespace Mod\LoginMod;

use App\Actions\ActionManager;
use Psr\Container\ContainerInterface;
use User\UserInterface;

final class ListenerFactory
{
    public function __invoke(ContainerInterface $container): Listener
    {
        return new Listener(
            $container->get(ActionManager::class),
            $container->get(Entity\LoginThingy::class),
            $container->get(UserInterface::class)
        );
    }
}
