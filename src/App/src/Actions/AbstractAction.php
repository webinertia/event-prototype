<?php

declare(strict_types=1);

namespace App\Actions;

use App\AppEvent;

use function method_exists;

abstract class AbstractAction extends InternalAbstractAction
{
    protected $eventIdentifier = self::class;

    protected ?string $tmplNamespace = null;

    public function onDispatch(AppEvent $event)
    {
        $request = $event->getRequest();
        $routeResult = $event->getRouteResult();
        $action = $routeResult->getParam('action', 'not-found');
        $subAction = $routeResult->getParam('sa');

        if (! method_exists($this, $action)) { // todo: improve this so action is not directly using the param, normalize . - etc
            // set a known not found method here from the InternalAbstractAction class
            // $action = 'someNotFoundMethod';
        }

        $result = $this->$action($subAction);
        $event->setResult($result);
        return $result;
    }
}
