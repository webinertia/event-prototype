<?php

declare(strict_types=1);

namespace App\Actions;

use Laminas\View\Exception\InvalidArgumentException;
use Laminas\View\Model\ModelInterface;
use Template\TemplateModel;
use User\Entity\User;
use User\UserInterface;

final class LoginAction extends AbstractAction
{
    public function __construct(
        private UserInterface&User $user
    ) {
        $this->template = new TemplateModel();
    }

    public function __invoke(?string $subAction = null): ModelInterface
    {
        $this->template->setTemplate('app:login');
        $this->getEvent()->setTemplate($this->template);
        return match($subAction) {
            'loginTwo' => $this->loginTwo($this->template),
            default => $this->template
        };
    }

    protected function loginTwo(TemplateModel $template)
    {
        $subTemplate = new TemplateModel();
        $subTemplate->setTemplate('app:login-two');
        $subTemplate->setVariables(['login_two_variable' => 'login_two_variable_value']);
        $template->addChild($subTemplate, 'loginTwo');
        return $template;
    }
}
