<?php

declare(strict_types=1);

namespace App\Actions;

use Template\TemplateModel;
use User\Entity\User;
use User\UserInterface;

final class LoginAction extends AbstractAction
{
    public function __construct(
        private UserInterface&User $user
    ) {
    }

    public function login(?string $subAction = null)
    {
        $model = new TemplateModel(); // return this for the moment to see if dispatch continues
        $model->setTemplate('app:login');
        return match($subAction) {
            'loginTwo' => $this->loginTwo($model),
            default => $model
        };
    }

    protected function loginTwo(TemplateModel $template)
    {
        $event = $this->getEvent();
        $subTemplate = new TemplateModel();
        $subTemplate->setTemplate('app:login-two');
        $subTemplate->setVariables(['login_two_variable' => 'login_two_variable_value']);
        $template->addChild($subTemplate);
        return $template;
    }
}
