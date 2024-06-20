<?php

declare(strict_types=1);

namespace User\Entity\Container;

use Psr\Container\ContainerInterface;
use User\Entity\User;
use User\UserInterface;

final class UserFactory
{
    public function __invoke(ContainerInterface $container): User
    {
        $guestData = [];
        $config = $container->get('config');
        if (! empty($config['mock-data'][UserInterface::class])) {
            $guestData = $config['mock-data'][UserInterface::class];
        }
        return new User($guestData);
    }
}
