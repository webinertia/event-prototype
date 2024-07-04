<?php

declare(strict_types=1);

namespace App\Container;

use App\Listeners\BoardIndexListener;
use Psr\Container\ContainerInterface;

final class BoardIndexListenerFactory
{
    public function __invoke(ContainerInterface $container): BoardIndexListener
    {
        return new BoardIndexListener();
    }
}
