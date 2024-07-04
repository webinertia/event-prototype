<?php

declare(strict_types=1);

namespace App\Listeners;

use App\DispatchableInterface;
use App\DispatchableInterfaceTrait;
use App\Actions\ActionManager;
use Laminas\EventManager\AbstractListenerAggregate;

final class ActionListener extends AbstractListenerAggregate
{
    public function __construct(
        private ActionManager $actionManager,
        private array $config
    ) {
    }
}
