<?php

declare(strict_types=1);

namespace App\Container;

use App\MessageListener;
use Psr\Container\ContainerInterface;

final class MessageListenerFactory
{
    public function __invoke(ContainerInterface $container): MessageListener
    {
        return new MessageListener();
    }
}
