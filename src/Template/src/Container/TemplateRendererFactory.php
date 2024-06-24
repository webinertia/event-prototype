<?php

declare(strict_types=1);

namespace Template\Container;

use Laminas\View\HelperPluginManager;
use Laminas\View\Renderer\PhpRenderer;
use Laminas\View\Resolver;
use Psr\Container\ContainerInterface;
use Template\NamespacedPathStackResolver;
use Template\TemplateRenderer;

use function is_array;
use function is_numeric;

final class TemplateRendererFactory
{
    public function __invoke(ContainerInterface $container): TemplateRenderer
    {
        $config = $container->has('config') ? $container->get('config') : [];
        $config = $config['templates'] ?? [];

        // Configuration
        $resolver = new Resolver\AggregateResolver();
        $resolver->attach(
            new Resolver\TemplateMapResolver($config['map'] ?? []),
            100
        );
        $resolver->attach(
            $container->get(NamespacedPathStackResolver::class),
            99
        );
        $renderer = new PhpRenderer();
        $renderer->setResolver($resolver);
        $renderer->setHelperPluginManager($container->get(HelperPluginManager::class));
        $templateRenderer = new TemplateRenderer($renderer, $config['layout'], $config['extension']);
        $allPaths = !empty($config['paths']) ? $config['paths'] : [];
        foreach ($allPaths as $namepace => $paths) {
            $namepace = is_numeric($namepace) ? null : $namepace;
            foreach ((array) $paths as $path) {
                $templateRenderer->addPath($path, $namepace);
            }
        }

        return $templateRenderer;
    }
}
