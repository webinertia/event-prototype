<?php

declare(strict_types=1);

namespace App\Container;

use App\Actions\ActionManager;
use App\Listeners\DispatchListener;
use Psr\Container\ContainerInterface;

final class DispatchListenerFactory
{
    public function __invoke(ContainerInterface $container): DispatchListener
    {
        return new DispatchListener(
            $container->get(ActionManager::class)
        );
    }
}
