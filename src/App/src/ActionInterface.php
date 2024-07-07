<?php

declare(strict_types=1);

namespace App;

use Psr\Http\Message\ResponseInterface;

interface ActionInterface
{
    public function __invoke(?string $subAction = null): ResponseInterface;
    public function onDispatch(AppEvent $event);
}
