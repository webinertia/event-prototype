<?php

declare(strict_types=1);

namespace Template\Container;

use Laminas\View\Renderer\PhpRenderer;
use Laminas\View\Strategy\PhpRendererStrategy;
use Psr\Container\ContainerInterface;

final class PhpRendererStrategyFactory
{
    public function __invoke(ContainerInterface $container): PhpRendererStrategy
    {
        return new PhpRendererStrategy($container->get(PhpRenderer::class));
    }
}
