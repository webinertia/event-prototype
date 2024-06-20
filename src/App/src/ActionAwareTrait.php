<?php

declare(strict_types=1);

namespace App;

trait ActionAwareTrait
{
    private array $actionArray = [];

    public function setActions(array $actionArray): void
    {
        $this->actionArray = $actionArray;
    }

    public function getActions(): array
    {
        return $this->actionArray;
    }

    public function getActionParam(string $action): ?string
    {
        if (isset($this->actionArray[$action])) {
            return $this->actionArray[$action]['param'];
        }
        return null;
    }

    public function getActionClass(string $action): ?string
    {
        if (isset($this->actionArray[$action]['class'])) {
            return $this->actionArray[$action]['class'];
        }
        return null;
    }
}
