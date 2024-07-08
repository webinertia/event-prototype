<?php

declare(strict_types=1);

namespace App\Actions;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Template\TemplateModel;
use User\Entity\User;
use User\UserInterface;

class LoginAction extends AbstractAction
{
    public function __construct(
        private UserInterface&User $user
    ) {
        $this->template = new TemplateModel();
    }

    public function __invoke(?string $subAction = null): ResponseInterface
    {
        $this->template->setTemplate('app:login');
        return match($subAction) {
            'loginTwo' => $this->loginTwo($this->template),
            default => new HtmlResponse(
                $this->renderer->render(
                    $this->template->getTemplate(),
                    $this->template)
            )
        };
    }

    protected function loginTwo(TemplateModel $template)
    {
        $subTemplate = new TemplateModel();
        $subTemplate->setTemplate('app:login-two');
        $subTemplate->setVariables(['login_two_variable' => 'login_two_variable_value']);
        $template->addChild($subTemplate, 'loginTwo');
        return new HtmlResponse(
            $this->renderer->render($template->getTemplate(), $template)
        );
    }
}
