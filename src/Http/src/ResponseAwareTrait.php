<?php

declare(strict_types=1);

namespace Http;

use Psr\Http\Message\ResponseInterface;

trait ResponseAwareTrait
{
    protected ?ResponseInterface $response = null;

    public function setResponse(ResponseInterface $response): void
    {
        $this->response = $response;
    }

    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }
}
