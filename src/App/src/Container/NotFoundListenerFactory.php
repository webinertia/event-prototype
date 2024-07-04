<?php

declare(strict_types=1);

namespace App\Container;

use App\Listeners\NotFoundListener;
use Psr\Container\ContainerInterface;

final class NotFoundListenerFactory
{
    public function __invoke(ContainerInterface $container): NotFoundListener
    {
        return new NotFoundListener($container->get('config'));
    }
}
