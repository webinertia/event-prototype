<?php

declare(strict_types=1);

namespace Template;

interface TemplateAwareInterface
{
    public function setTemplate(TemplateRendererInterface $template): void;
    public function getTemplate(): ?TemplateRendererInterface;
}
