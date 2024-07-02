<?php

declare(strict_types=1);

namespace Http\Container;

use Laminas\Diactoros\ServerRequestFactory as Factory;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;

final class ServerRequestFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /** @var Factory */
        $factory = $container->get(ServerRequestFactoryInterface::class);
        $request = $factory::fromGlobals();
        return $request;
    }
}
