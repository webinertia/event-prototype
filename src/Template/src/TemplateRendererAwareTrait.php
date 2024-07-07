<?php

declare(strict_types=1);

namespace Template;

trait TemplateRendererAwareTrait
{
    protected ?TemplateRendererInterface $renderer = null;

    public function setRenderer(TemplateRendererInterface $renderer): void
    {
        $this->renderer = $renderer;
    }

    public function getRenderer(): ?TemplateRendererInterface
    {
        return $this->renderer;
    }
}
