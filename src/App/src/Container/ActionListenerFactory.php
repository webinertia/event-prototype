<?php

declare(strict_types=1);

namespace App\Container;

use App\ActionListener;
use App\Actions\ActionManager;
use Psr\Container\ContainerInterface;

final class ActionListenerFactory
{
    public function __invoke(ContainerInterface $container): ActionListener
    {
        return new ActionListener($container->get(ActionManager::class));
    }
}
