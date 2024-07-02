<?php

declare(strict_types=1);

namespace App;

interface InjectAppEventInterface
{
    public function setEvent(AppEvent $event): void;
}
