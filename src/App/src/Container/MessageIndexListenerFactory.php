<?php

declare(strict_types=1);

namespace App\Container;

use App\Listeners\MessageIndexListener;
use Psr\Container\ContainerInterface;

final class MessageIndexListenerFactory
{
    public function __invoke(ContainerInterface $container): MessageIndexListener
    {
        return new MessageIndexListener();
    }
}
