<?php

declare(strict_types=1);

namespace Template;

interface TemplateRendererAwareInterface
{
    public function setRenderer(TemplateRendererInterface $renderer): void;
    public function getRenderer(): ?TemplateRendererInterface;
}
