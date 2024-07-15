<?php

declare(strict_types=1);

namespace Template\Helper\Container;

use Laminas\View\Helper\BasePath;
use Psr\Container\ContainerInterface;

final class BasePathFactory
{
    public function __invoke(ContainerInterface $container): BasePath
    {
        $config = $container->get('config');
        return new BasePath($config['template_helper_config']['base_path']);
    }
}
