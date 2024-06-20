<?php

declare(strict_types=1);

namespace Template\Container;

use Laminas\View\HelperPluginManager;
use Psr\Container\ContainerInterface;

final class HelperPluginManagerFactory
{
    public function __invoke(ContainerInterface $container): HelperPluginManager
    {
        $manager = new HelperPluginManager($container);
        $config = $container->has('config') ? $container->get('config') : [];
        $helperConfig = $config['template_helpers'] ?? [];

        if (! empty($helperConfig)) {
            $manager->configure($helperConfig);
        }
        return $manager;
    }
}
