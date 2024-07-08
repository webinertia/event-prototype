<?php

declare(strict_types=1);

namespace App\Actions;

use App\AppEvent;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractAction extends InternalAbstractAction
{
    protected $eventIdentifier = self::class;

    public function onDispatch(AppEvent $event): ResponseInterface
    {
        $routeResult = $event->getRouteResult();
        $subAction = $routeResult->getParam('query')['sa'] ?? null;
        $result = $this($subAction);
        $event->setResult($result);
        return $result;
    }
}
