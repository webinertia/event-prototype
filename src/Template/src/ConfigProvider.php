<?php

declare(strict_types=1);

namespace Template;

use Assetic\AssetManager;
use Laminas\View\Helper\BasePath;
use Laminas\View\Helper\Doctype;
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
            'listeners'              => $this->getListenerConfig(),
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
                AssetManager::class                => Container\AssetManagerFactory::class,
                AssetListener::class               => Container\AssetListenerFactory::class,
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
        return [
            'delegators' => [
                Doctype::class => [
                    Helper\Container\DocTypeDelegatorFactory::class,
                ],
            ],
            'factories'  => [
                BasePath::class => Helper\Container\BasePathFactory::class,
            ],
        ];
    }

    public function getHelperConfig(): array
    {
        return [
            'doctype'   => 'HTML5',
            'base_path' => '/',
        ];
    }

    public function getListenerConfig(): array
    {
        return [
            AssetListener::class,
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
