<?php

declare(strict_types=1);

namespace App;

use App\AppEvent;
use Laminas\EventManager\EventManagerInterface;
use Psr\Http\Message\ResponseInterface;

interface DispatchableInterface extends ActionAwareInterface
{
    public function attach(EventManagerInterface $events, $priority = 1);
    public function onDispatch(AppEvent $event): ?ResponseInterface;
}
