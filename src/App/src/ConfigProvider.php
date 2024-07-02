<?php

declare(strict_types=1);

namespace App;

use App\Container;
use App\Actions\Listener\LoginListener;
use App\Actions\LoginAction;
use Http\Container\Psr7AwareDelegatorFactory;
use Laminas\EventManager\EventManager;
use Laminas\EventManager\EventManagerInterface;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Mod\LoginMod\Listener;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Template\Container\TemplateAwareInitializer;


final class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            ActionInterface::class => $this->getActions(),
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
                Listeners\ActionListener::class       => Container\ActionListenerFactory::class,
                Listeners\BoardIndexListener::class   => Container\BoardIndexListenerFactory::class,
                Listeners\DispatchListener::class     => Container\DispatchListenerFactory::class,
                Listeners\DisplayListener::class      => Container\DisplayListenerFactory::class,
                Listeners\EmitResponseListener::class => Container\EmitResponseListenerFactory::class,
                Listeners\MessageIndexListener::class => Container\MessageIndexListenerFactory::class,
                Listeners\NotFoundListener::class     => Container\NotFoundListenerFactory::class,
                LoginListener::class                  => InvokableFactory::class,
                Listeners\RouteListener::class        => Container\RouteListenerFactory::class,
            ],
            'delegators' => [
                App::class => [
                    Psr7AwareDelegatorFactory::class,
                ],
            ],
            'initializers' => [
                Container\ActionAwareInitializer::class,
                TemplateAwareInitializer::class,
            ],
        ];
    }

    public function getActions(): array
    {
        return [
            'login' => [
                'param' => 'login',
                'class' => LoginAction::class,
            ],
        ];
    }

    public function getActionManagerConfig(): array
    {
        return [
            'aliases'   => [
                ActionInterface::EVENT_LOGIN => LoginAction::class,
            ],
            'delegators' => [
                // LoginAction::class => [
                //     RequestAwareDelegatorFactory::class, // runs only for LoginAction
                // ],
            ],
            'factories' => [
                LoginAction::class => Actions\Container\LoginActionFactory::class,
            ],
            'initializers' => [
                Actions\Container\EventManagerAwareInitializer::class, // Runs for all services created by ActionManager
                //Container\ActionAwareInitializer::class,
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
                'name'   => 'app.login',
                'action' => 'login',
                'methods' => ['GET', 'POST'],
                'actionClass' => Actions\LoginAction::class
            ],

        ];
    }
}
