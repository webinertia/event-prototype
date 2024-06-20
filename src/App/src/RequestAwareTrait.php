<?php

declare(strict_types=1);

namespace App;

use Laminas\Diactoros\ServerRequest;

trait RequestAwareTrait
{
    protected ?ServerRequest $request = null;

    public function setRequest(ServerRequest $request): void
    {
        $this->request = $request;
    }

    public function getRequest(): ?ServerRequest
    {
        return $this->request;
    }
}
