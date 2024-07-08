<?php

declare(strict_types=1);

namespace Http;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

interface DispatchableInterface
{
    /**
     * Dispatch a request
     */
    public function dispatch(ServerRequestInterface $request, ?ResponseInterface $response = null): ResponseInterface;
}
