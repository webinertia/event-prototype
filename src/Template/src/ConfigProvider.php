<?php

declare(strict_types=1);

namespace Template;

use Laminas\View\HelperPluginManager;
use Laminas\View\Strategy\PhpRendererStrategy;

final class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'action_manager'         => $this->getActionManagerConfig(),
            'dependencies'           => $this->getDependencies(),
            'template_helpers'       => $this->getHelpers(),
            'template_helper_config' => $this->getHelperConfig(), // seed the template helpers with config
            'templates'              => $this->getTemplates(),
        ];
    }

    public function getDependencies(): array
    {
        return [
            'aliases'   => [
                'TemplateResolver' => TemplateResolverInterface::class,
                TemplateRendererInterface::class => TemplateRenderer::class,
            ],
            'factories' => [
                HelperPluginManager::class         => Container\HelperPluginManagerFactory::class,
                TemplateRenderer::class            => Container\TemplateRendererFactory::class,
                TemplateResolverInterface::class   => Container\TemplateResolverFactory::class,
                PhpRendererStrategy::class         => Container\PhpRendererStrategyFactory::class,
                NamespacedPathStackResolver::class => Container\NamespacedPathStackResolverFactory::class,
            ],
        ];
    }

    public function getActionManagerConfig(): array
    {
        return [
            'initializers' => [
                Container\TemplateRendererAwareInitializer::class,
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

    public function getTemplates(): array
    {
        return [
            'extension' => 'phtml',
            'layout'    => 'layout:layout',
            'paths'     => [
                'layout' => [__DIR__ . '/../templates/layout'],
                'app'    => [__DIR__ . '/../templates/app'],
            ],
        ];
    }
}
