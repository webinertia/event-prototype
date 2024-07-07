<?php

declare(strict_types=1);

namespace App\Container;

use App\Listeners\EmitResponseListener;
use Laminas\HttpHandlerRunner\Emitter\EmitterInterface;
use Psr\Container\ContainerInterface;
use Template\TemplateRendererInterface;

final class EmitResponseListenerFactory
{
    public function __invoke(ContainerInterface $container): EmitResponseListener
    {
        return new EmitResponseListener(
            $container->get(EmitterInterface::class)
        );
    }
}
