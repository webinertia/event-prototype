<?php

declare(strict_types=1);

use User\UserInterface;

return [
    'mock-data' => [
        UserInterface::class => [
            'userId'   => 0,
            'userName' => 'Guest',
            'role'     => 'guest',
        ],
    ],
];