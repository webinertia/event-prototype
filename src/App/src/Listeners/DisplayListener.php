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
use function sprintf;

final class DisplayListener extends AbstractListenerAggregate
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
        if(array_key_exists('board', $params) && array_key_exists('topic', $params)) {
            $string = '<b> Displaying results for Board id = %s Topic id = %s';
            return new HtmlResponse(
                sprintf(
                    $string,
                    $params['board'],
                    $params['topic']
                )
            );
        }
        return null;
    }
}
