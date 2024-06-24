<?php

declare(strict_types=1);

namespace Mod\LoginMod\Actions;

use App\Actions\AbstractAction;
use App\RequestAwareInterface;
use App\RequestAwareTrait;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;

final class CustomAction extends AbstractAction implements RequestAwareInterface
{
    use RequestAwareTrait;

    private string $tmpl = 'custom-action';

    public function run(): ?ResponseInterface
    {
        $eventManager = $this->getEventManager();

        $template = $this->getTemplate();

        return new HtmlResponse($template->render('login-mod:' . $this->tmpl));
    }
}
