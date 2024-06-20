<?php

declare(strict_types=1);

namespace App;

use App\Actions\ActionManager;
use Laminas\EventManager\AbstractListenerAggregate;

final class ActionListener extends AbstractListenerAggregate implements DispatchableInterface
{
    use DispatchableInterfaceTrait;

    public function __construct(
        private ActionManager $actionManager
    ) {
    }
}
