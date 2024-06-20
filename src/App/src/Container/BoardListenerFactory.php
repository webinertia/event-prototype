<?php

declare(strict_types=1);

namespace App\Container;

use App\BoardListener;
use Psr\Container\ContainerInterface;

final class BoardListenerFactory
{
    public function __invoke(ContainerInterface $container): BoardListener
    {
        return new BoardListener();
    }
}
