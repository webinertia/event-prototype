<?php

declare(strict_types=1);

namespace Template;

/**
 * Credit Mezzio
 *
 * Interface defining required template capabilities.
 */
interface TemplateRendererInterface
{
    /**
     * @const string Value indicating all templates; used with `addDefaultParam()`.
     */
    public const TEMPLATE_ALL = '*';

    /**
     * Render a template, optionally with parameters.
     *
     * Implementations MUST support the `namespace::template` naming convention,
     * and allow omitting the filename extension.
     *
     * @param array|object $params
     */
    public function render(string $name, $params = []): string;

    /**
     * Add a template path to the engine.
     *
     * Adds a template path, with optional namespace the templates in that path
     * provide.
     */
    public function addPath(string $path, ?string $namespace = null): void;

    /**
     * Retrieve configured paths from the engine.
     *
     * @return TemplatePath[]
     */
    public function getPaths(): array;
}
