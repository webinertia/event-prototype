<?php

declare(strict_types=1);

namespace App;

use Laminas\View\Model\ModelInterface;

interface ActionInterface
{
    public function __invoke(?string $subAction = null): ModelInterface;
    public function onDispatch(AppEvent $event);
}
