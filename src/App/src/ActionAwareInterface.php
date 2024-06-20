<?php

declare(strict_types=1);

namespace App;

interface ActionAwareInterface
{
    public function setActions(array $actionArray): void;
    public function getActions(): ?array;
}
