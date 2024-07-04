<?php

declare(strict_types=1);

namespace App;

use Template\TemplateAwareInterface;

interface ActionAwareInterface extends TemplateAwareInterface
{
    public function setActions(array $actionArray): void;
    public function getActions(): ?array;
}
