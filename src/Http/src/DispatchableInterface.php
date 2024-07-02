<?php

declare(strict_types=1);

namespace Http;

use App\AppEvent;
use Laminas\EventManager\EventManagerInterface;
use Laminas\View\Model\ModelInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

interface DispatchableInterface
{
    // /** @deprecated */
    // public function attach(EventManagerInterface $events, $priority = 1);

    // /** @deprecated */
    // public function onDispatch(AppEvent $event): ModelInterface|array;
    /**
     * Dispatch a request
     *
     * @return Response|mixed
     */
    public function dispatch(ServerRequestInterface $request, ?ResponseInterface $response = null);
}
