<?php

declare(strict_types=1);

namespace App;

use App\ActionAwareTrait as AppActionAwareTrait;
use App\Actions\ActionAwareTrait;
use Laminas\Diactoros\ServerRequest;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\EventInterface;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Psr\Http\Message\ResponseInterface;

trait DispatchableInterfaceTrait
{
    use AppActionAwareTrait;

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(AppEvents::Dispatch->value, [$this, 'onDispatch'], $priority);
    }

    public function onDispatch(AppEvent $event): ?ResponseInterface
    {
        /** @var ServerRequest */
        $request = $event->getParam('request');
        $params  = $request->getQueryParams();

        if (! empty($params['action'])) {
            try {
                /**
                 * $action is the action=someaction
                 * it must be a valid value for the Action enum which codifies known actions
                 * expects mods to expose an backed enum Action to describe the custom action
                 */
                $action = $this->getActionClass($params['action']);
                /**
                 * The called action must return a ResponseInterface instance or it will 404
                 *
                 * Maps ['config']['actions'][$action]['class'] to $actionManager service name
                 */
                return ($this->actionManager->get($action))->run();
            } catch (ServiceNotFoundException $e) {
                // todo: handle catching this....
            }
        }
        return null;
    }
}
