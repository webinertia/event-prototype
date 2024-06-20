<?php

declare(strict_types=1);

namespace Mod\LoginMod;

use App\Actions\ActionManager;
use App\AppEvent;
use App\AppEvents;
use App\DispatchableInterface;
use App\DispatchableInterfaceTrait;
use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventInterface;
use Laminas\EventManager\EventManagerInterface;
use Mod\LoginMod\Action;
use Psr\Http\Message\ResponseInterface;
use User\Entity\User;
use User\UserInterface;

final class Listener extends AbstractListenerAggregate implements DispatchableInterface
{
    use DispatchableInterfaceTrait;

    public function __construct(
        private ActionManager $actionManager,
        private Entity\LoginThingy $loginThingy,
        private UserInterface&User $user,
    ) {
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(AppEvents::Bootstrap->value, [$this, 'onBootstrap'], $priority);
        $this->listeners[] = $events->attach(AppEvents::Dispatch->value, [$this, 'onDispatch'], $priority);
        $this->listeners[] = $events->attach(LoginMod::TARGET_EVENT, [$this, 'onLogin'], $priority);
    }

    public function onBootstrap(AppEvent $event)
    {
        $app = $event->getApp();
    }

    public function onLogin(EventInterface $event)
    {
        $user = $event->getParam('userInstance');
        $user->modProperty = 'Some Mod Value';
    }
}
