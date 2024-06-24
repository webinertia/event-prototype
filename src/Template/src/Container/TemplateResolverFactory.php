<?php

declare(strict_types=1);

namespace Template\Container;

use Laminas\View\Resolver\AggregateResolver;
use Psr\Container\ContainerInterface;
use Template\NamespacedPathStackResolver;

final class TemplateResolverFactory
{
    public function __invoke(ContainerInterface $container): AggregateResolver
    {
        $resolver = new AggregateResolver();
        $namespaceResolver = $container->get(NamespacedPathStackResolver::class); // todo: write factory
        $resolver->attach($namespaceResolver);
        return $resolver;
    }
}
