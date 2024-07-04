<?php

declare(strict_types=1);

namespace Http\Container;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

final class ResponseFactory
{
    public function __invoke(ContainerInterface $container): ResponseInterface
    {
        $factory = $container->get(ResponseFactoryInterface::class);
        return $factory->createResponse();
    }
}
