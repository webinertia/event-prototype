<?php

declare(strict_types=1);

namespace App;

use App\DispatchableInterface;
use App\DispatchableInterfaceTrait;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\ServerRequest;
use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventInterface;
use Laminas\EventManager\EventManagerInterface;
use Psr\Http\Message\ResponseInterface;

use function array_key_exists;
use function sprintf;

final class DisplayListener extends AbstractListenerAggregate implements DispatchableInterface
{
    use DispatchableInterfaceTrait;

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
