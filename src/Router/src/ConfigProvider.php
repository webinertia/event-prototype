<?php

declare(strict_types=1);

namespace Router;

final class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'routes'       => $this->getRoutes(),
        ];
    }

    public function getDependencies(): array
    {
        return [
            'aliases'   => [
                RouterInterface::class => RouteStack::class,
            ],
            'factories' => [
                RouteStack::class => Container\RouteStackFactory::class,
            ],
        ];
    }

    public function getRoutes(): array
    {
        return [];
    }
}
