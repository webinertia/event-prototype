<?php

declare(strict_types=1);

namespace App\Actions;

use Laminas\View\Model\ModelInterface;
use Template\TemplateModel;

final class DisplayAction extends AbstractAction
{
    public function __invoke(?string $subAction = null): ModelInterface
    {
        $this->template = new TemplateModel();
        $this->template->setTemplate('app:display');
        $this->getEvent()->setTemplate($this->template);
        return $this->template;
    }
}
