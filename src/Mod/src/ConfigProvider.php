<?php

declare(strict_types=1);

namespace Mod;

use App\ActionInterface;

final class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            ActionInterface::class => $this->getCustomActions(),
            'dependencies' => $this->getDependencies(),
            'actions'      => $this->getCustomActions(), // mod authors use this key to inject custom actions
        ];
    }

    public function getDependencies(): array
    {
        return [];
    }

    public function getCustomActions(): array
    {
        return [];
    }
}
