<?php

declare(strict_types=1);

namespace App\Listeners;

use App\DispatchableInterface;
use App\DispatchableInterfaceTrait;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\ServerRequest;
use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventInterface;
use Psr\Http\Message\ResponseInterface;

use function array_key_exists;

final class MessageIndexListener extends AbstractListenerAggregate implements DispatchableInterface
{
    use DispatchableInterfaceTrait;

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
