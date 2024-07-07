<?php

declare(strict_types=1);

namespace App;

use Http\Container\Psr7AwareDelegatorFactory;
use Laminas\EventManager\EventManager;
use Laminas\EventManager\EventManagerInterface;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Template\Container\TemplateAwareInitializer;


final class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'action_manager' => $this->getActionManagerConfig(),
            'dependencies'   => $this->getDependencies(),
            'listeners'      => [], // list of listeners to attach, easy for mod authors
            'templates'      => $this->getTemplates(),
            'routes'         => $this->getRoutes(),
        ];
    }

    public function getDependencies(): array
    {
        return [
            'aliases'   => [
                'Context' => ContextInterface::class,
                'context' => ContextInterface::class,
                ContextInterface::class => ContextContainer::class,
                'EventManager'               => EventManagerInterface::class, // many underlying laminas components expect to find this Service Name
                EventManagerInterface::class => EventManager::class,
            ],
            'factories' => [
                Actions\ActionManager::class          => Actions\Container\ActionManagerFactory::class,
                App::class                            => Container\AppFactory::class,
                ContextContainer::class               => Container\ContextContainerFactory::class,
                EventManager::class                   => Container\EventManagerFactory::class,
                Listeners\DispatchListener::class     => Container\DispatchListenerFactory::class,
                Listeners\EmitResponseListener::class => Container\EmitResponseListenerFactory::class,
                Listeners\NotFoundListener::class     => Container\NotFoundListenerFactory::class,
                Listeners\RenderListener::class       => Container\RenderListenerFactory::class,
                Listeners\RouteListener::class        => Container\RouteListenerFactory::class,
            ],
            'delegators' => [
                App::class => [
                    Psr7AwareDelegatorFactory::class,
                ],
            ],
            'initializers' => [
                TemplateAwareInitializer::class,
            ],
        ];
    }

    public function getActionManagerConfig(): array
    {
        return [
            'factories' => [
                Actions\BoardIndexAction::class   => InvokableFactory::class,
                Actions\DisplayAction::class      => InvokableFactory::class,
                Actions\MessageIndexAction::class => InvokableFactory::class,
                Actions\LoginAction::class        => Actions\Container\LoginActionFactory::class,
            ],
            'initializers' => [
                Actions\Container\EventManagerAwareInitializer::class, // Runs for all services created by ActionManager
            ],
        ];
    }

    public function getTemplates(): array
    {
        return [
            'paths' => [
                'app'    => [__DIR__ . '/../templates/app'],
                'error'  => [__DIR__ . '/../templates/error'],
                'layout' => [__DIR__ . '/../templates/layout'],
            ],
        ];
    }

    public function getRoutes(): array
    {
        return [
            [
                'name'   => 'app.board.index',
                'query' => [],
                'methods' => ['GET'],
                'action_class' => Actions\BoardIndexAction::class,
            ],
            [
                'name' => 'app.message.index',
                'methods' => ['GET'],
                'query' => [
                    'board'
                ],
                'action_class' => Actions\MessageIndexAction::class,
            ],
            [
                'name' => 'app.display',
                'methods' => ['GET', 'POST'],
                'query' => ['topic'],
                'action_class' => Actions\DisplayAction::class,
            ],
            [
                'name'   => 'app.login',
                'query' => [
                    'action' => 'login',
                ],
                'methods' => ['GET', 'POST'],
                'action_class' => Actions\LoginAction::class,
            ],
            [
                'name'   => 'app.login.loginTwo',
                'query' => [
                    'action' => 'login',
                    'sa'     => 'loginTwo',
                ],
                'methods' => ['GET', 'POST'],
                'action_class' => Actions\LoginAction::class,
            ],
        ];
    }
}
