<?php

declare(strict_types=1);

namespace App\Actions;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;

class MessageIndexAction extends AbstractAction
{
    public function __invoke(?string $subAction = null): ResponseInterface
    {
        return new HtmlResponse(
            $this->renderer->render(
                'app:message-index',
                [
                    'data' => ['some_key' => 'some_value']
                ]
            )
        );
    }
}
