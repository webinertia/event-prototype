<?php

declare(strict_types=1);

namespace App\Container;

use App\ContextContainer;
use App\ContextInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ContextContainerFactory
{
    public function __invoke(ContainerInterface $container): ContextContainer
    {
        $contextContainer = new ContextContainer();
        $request          = $container->get(ServerRequestInterface::class);
        $request          = $request->withAttribute(ContextInterface::class, $contextContainer);
        return $contextContainer;
    }
}
