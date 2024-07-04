<?php

declare(strict_types=1);

namespace App\Container;

use App\Listeners\RouteListener;
use Router\RouterInterface;
use Psr\Container\ContainerInterface;

final class RouteListenerFactory
{
    public function __invoke(ContainerInterface $container): RouteListener
    {
        return new RouteListener($container->get(RouterInterface::class));
    }
}
