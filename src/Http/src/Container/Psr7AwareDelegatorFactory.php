<?php

declare(strict_types=1);

namespace Http\Container;

use Http\Psr7AwareInterface;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

final class Psr7AwareDelegatorFactory implements DelegatorFactoryInterface
{

    public function __invoke(ContainerInterface $container, $name, callable $callback, ?array $options = null): ?Psr7AwareInterface
    {
        $instance = $callback();
        if (! $instance instanceof Psr7AwareInterface) {
            return null;
        }
        $instance->setRequest($container->get(ServerRequestInterface::class));
        $instance->setResponse($container->get(ResponseInterface::class));
        return $instance;
    }

}
