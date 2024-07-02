<?php

declare(strict_types=1);

namespace App\Actions;

use App\AppEvent;

abstract class AbstractAction extends InternalAbstractAction
{
    public function onDispatch(AppEvent $event)
    {

    }
}
