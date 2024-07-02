<?php

declare(strict_types=1);

namespace Router\Container;

use Psr\Container\ContainerInterface;
use Router\RouteStack;
use Router\RouterInterface;

final class RouteStackFactory
{
    public function __invoke(ContainerInterface $container): RouterInterface
    {
        return RouteStack::factory($container->get('config'));
    }
}
