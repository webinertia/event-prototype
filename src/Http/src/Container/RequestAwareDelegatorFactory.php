<?php

declare(strict_types=1);

namespace Http\Container;

use Http\RequestAwareInterface;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RequestAwareDelegatorFactory implements DelegatorFactoryInterface
{
    /** @inheritDoc */
    public function __invoke(ContainerInterface $container, $name, callable $callback, ?array $options = null)
    {
        $instance = $callback(); // call the original invokable factory as a functor
        if (! $instance instanceof RequestAwareInterface) {
            return $instance;
        }
        $instanceRequest = $instance->getRequest();
        if (! $instanceRequest instanceof ServerRequest) {
            /** @var ServerRequestFactory */
            //$factory = $container->get(ServerRequestFactoryInterface::class);
            $instance->setRequest($container->get(ServerRequestInterface::class));
        }
        return $instance;
    }
}
