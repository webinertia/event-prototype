<?php

declare(strict_types=1);

namespace App;

use Psr\Http\Message\ResponseInterface;

interface ActionInterface
{
    final public const EVENT_LOGIN = 'login';
}
