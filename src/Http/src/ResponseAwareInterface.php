<?php

declare(strict_types=1);

namespace Http;

use Psr\Http\Message\ResponseInterface;

interface ResponseAwareInterface
{
    public function setResponse(ResponseInterface $response): void;
    public function getResponse(): ?ResponseInterface;
}
