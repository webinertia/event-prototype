<?php

declare(strict_types=1);

namespace App;

use Psr\Http\Message\ResponseInterface;

interface ActionInterface
{
    public const LOGIN_EVENT = 'login';
    public function run(): ?ResponseInterface;
}
