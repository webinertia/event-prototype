<?php

declare(strict_types=1);

namespace Http;

use Laminas\HttpHandlerRunner\Emitter\EmitterInterface;
use Psr\Http\Message;

final class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    public function getDependencies(): array
    {
        return [
            'aliases'   => [],
            'factories' => [
                EmitterInterface::class               => Container\EmitterFactory::class,
                Message\ResponseInterface::class      => Container\ResponseFactory::class,
                Message\ServerRequestInterface::class => Container\ServerRequestFactory::class
            ],
        ];
    }
}
