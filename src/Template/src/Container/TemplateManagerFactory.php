<?php

declare(strict_types=1);

namespace Template\Container;

use Template\TemplateManager;
use Psr\Container\ContainerInterface;

final class TemplateManagerFactory
{
    public function __invoke(ContainerInterface $container): TemplateManager
    {
        return new TemplateManager();
    }
}
