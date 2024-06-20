<?php

declare(strict_types=1);

namespace App\Actions\Container;

use App\Actions\ActionManager;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Psr\Container\ContainerInterface;

final class ActionManagerFactory
{
    public function __invoke(ContainerInterface $container): ActionManager
    {
        if (! $container->has('config')) {
			throw new ServiceNotFoundException('ActionManager requires a config service');
		}
		$config = $container->get('config');
		if (! isset($config['action_manager'])) {
			throw new ServiceNotCreatedException('Missing configuration for ActionManager.');
		}
		return new ActionManager($container, $config['action_manager']);
    }
}
