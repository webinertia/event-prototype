<?php

declare(strict_types=1);

namespace App\Actions;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;

class BoardIndexAction extends AbstractAction
{
    public function __invoke(?string $subAction = null): ResponseInterface
    {
        return new HtmlResponse($this->renderer->render('app:board-index', ['board' => '1.0']));
    }
}
