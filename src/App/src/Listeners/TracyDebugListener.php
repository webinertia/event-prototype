<?php

declare(strict_types=1);

namespace App\Listeners;

use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventManagerInterface;

final class TracyDebugListener extends AbstractListenerAggregate
{

    public function attach(EventManagerInterface $events, $priority = 1) { }

}
