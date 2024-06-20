<?php

declare(strict_types=1);

namespace App;

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\ServerRequest;
use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventInterface;
use Psr\Http\Message\ResponseInterface;

final class BoardListener extends AbstractListenerAggregate implements DispatchableInterface
{
    use DispatchableInterfaceTrait;

    public function onDispatch(EventInterface $event): ?ResponseInterface
    {
        /** @var ServerRequest */
        $request = $event->getParam('request');
        if ([] === $request->getQueryParams()) {
            return new HtmlResponse('<b>Render BoardIndex</b>');
        }
        return null;
    }
}
