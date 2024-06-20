<?php

declare(strict_types=1);

namespace App;

use Laminas\Diactoros\ServerRequest;

interface RequestAwareInterface
{
    public function setRequest(ServerRequest $request): void;
    public function getRequest(): ?ServerRequest;
}
