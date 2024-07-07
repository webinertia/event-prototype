<?php

declare(strict_types=1);

namespace Mod\LoginMod;

use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'action_manager' => [
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
    'routes' => [
        [
            'name'   => 'loginmod.custom.action',
            'query' => [
                'action' => 'custom-action',
            ],
            'methods' => ['GET'],
            'action_class' => Actions\CustomAction::class,
        ],
    ],
    'templates' => [
        'paths' => [
            'login-mod' => [__DIR__ . '/../templates/login-mod'],
        ],
    ],
];