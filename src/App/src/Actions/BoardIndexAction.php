<?php

declare(strict_types=1);

namespace App\Actions;

use Laminas\View\Model\ModelInterface;
use Template\TemplateModel;

class BoardIndexAction extends AbstractAction
{
    public function __invoke(?string $subAction = null): ModelInterface
    {
        $this->template = new TemplateModel();
        $this->template->setTemplate('app:board-index');
        $event = $this->getEvent();
        $event->setTemplate($this->template);
        return $this->template;
    }
}
