<?php

declare(strict_types=1);

namespace Template\Container;

use Assetic\AssetManager;
use Psr\Container\ContainerInterface;
use Template\AssetListener;

final class AssetListenerFactory
{
    public function __invoke(ContainerInterface $container): AssetListener
    {
        return new AssetListener(
            $container->get(AssetManager::class),
            $container->get('config')['template_helper_config']
        );
    }
}
