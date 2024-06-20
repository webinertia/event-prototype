<?php

declare(strict_types=1);

namespace App\Actions\Listener;

use App\ActionAwareInterface;
use App\ActionAwareTrait;
use App\ActionInterface;
use App\Actions\LoginAction;
use App\AppEvents;
use Laminas\Diactoros\ServerRequest;
use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventInterface;
use Laminas\EventManager\EventManagerInterface;
use User\Entity\User;

final class LoginListener extends AbstractListenerAggregate implements ActionAwareInterface
{
    use ActionAwareTrait;

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(ActionInterface::LOGIN_EVENT, [$this, 'onLogin'], 10000);
    }

    public function onLogin(EventInterface $event)
    {
        /** @var User */
        $user = $event->getParam('userInstance');
        $user->exchangeArray($event->getParam('userData'));
        /** @var LoginAction */
        $target = $event->getTarget();
    }
}
