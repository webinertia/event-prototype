<?php

declare(strict_types=1);

namespace Mod\LoginMod\Actions;

use App\Actions\AbstractAction;
use Laminas\View\Model\ModelInterface;
use Template\TemplateModel;

final class CustomAction extends AbstractAction
{

    private string $tmpl = 'custom-action';

    public function __invoke(?string $subAction = null): ModelInterface
    {
        $this->template = new TemplateModel();
        $this->template->setTemplate('login-mod:custom-action');
        return $this->template;
    }

}
