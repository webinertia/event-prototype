<?php

declare(strict_types=1);

namespace Template;

trait TemplateAwareTrait
{
    protected ?TemplateRendererInterface $template = null;

    public function setTemplate(TemplateRendererInterface $template): void
    {
        $this->template = $template;
    }

    public function getTemplate(): ?TemplateRendererInterface
    {
        return $this->template;
    }
}
