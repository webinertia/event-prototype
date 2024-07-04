<?php

declare(strict_types=1);

namespace App\Container;

use App\Actions\ActionManager;
use App\Listeners\DisplayListener;
use Psr\Container\ContainerInterface;

final class DisplayListenerFactory
{
    public function __invoke(ContainerInterface $container): DisplayListener
    {
        return new DisplayListener($container->get(ActionManager::class));
    }
}
