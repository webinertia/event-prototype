<?php

declare(strict_types=1);

namespace App\Listeners;

use App\AppEvent;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\ServerRequest;
use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventInterface;
use Laminas\EventManager\EventManagerInterface;
use Psr\Http\Message\ResponseInterface;

use function array_key_exists;

final class MessageIndexListener extends AbstractListenerAggregate
{

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(AppEvent::EVENT_DISPATCH, [$this, 'onDispatch']);
    }

    public function onDispatch(EventInterface $event): ?ResponseInterface
    {
        /** @var ServerRequest */
        $request = $event->getParam('request');
        $params  = $request->getQueryParams();
        if (! empty($params['board']) && empty($params['topic'])) {
            return new HtmlResponse('<b>Render MessageIndex for board id = ' . $params['board'] . ' </b>');
        }
        return null;
    }
}
