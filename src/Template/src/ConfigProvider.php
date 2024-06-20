<?php

declare(strict_types=1);

namespace Template;

use Laminas\View\HelperPluginManager;
use Laminas\View\Resolver\AggregateResolver;
use Laminas\View\Strategy\PhpRendererStrategy;

final class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies'           => $this->getDependencies(),
            'template_helpers'       => $this->getHelpers(),
            'template_helper_config' => $this->getHelperConfig(), // seed the template helpers with config
        ];
    }

    public function getDependencies(): array
    {
        return [
            'aliases'   => [
                'TemplateResolver' => AggregateResolver::class,
            ],
            'factories' => [
                TemplateManager::class     => Container\TemplateManagerFactory::class,
                PhpRendererStrategy::class => Container\PhpRendererStrategyFactory::class,
            ],
        ];
    }

    public function getHelpers(): array
    {
        return [];
    }

    public function getHelperConfig(): array
    {
        return [
            'doctype' => 'HTML5',
        ];
    }
}
