<?php

declare(strict_types=1);

namespace Mod\LoginMod;

use App\ActionInterface;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    ActionInterface::class => [
        'custom-action' => [
            'param' => 'custom-action',
            'class' => Actions\CustomAction::class,
        ],
    ],
    'action_manager' => [
        'aliases' => [
            LoginMod::TARGET_EVENT => Actions\CustomAction::class,
        ],
        'factories' => [
            Actions\CustomAction::class => InvokableFactory::class,
        ],
    ],
    'dependencies' => [
        'factories' => [
            Entity\LoginThingy::class => InvokableFactory::class,
            Listener::class => ListenerFactory::class,
        ],
    ],
    'listeners' => [
        Listener::class,
    ],
];