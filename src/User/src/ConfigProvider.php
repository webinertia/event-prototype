<?php

declare(strict_types=1);

namespace User;

use Laminas\ServiceManager\Factory\InvokableFactory;

final class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    public function getDependencies(): array
    {
        return [
            'aliases'   => [
                UserInterface::class => Entity\User::class,
            ],
            'factories' => [
                Entity\User::class => Entity\Container\UserFactory::class,
            ],
        ];
    }
}
