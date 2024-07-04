<?php

declare(strict_types=1);

namespace Router;

use function array_key_exists;

final class RouteResult
{
    public function __construct(
        private ?string $matchedRouteName = null,
        private ?array $params = null,
    ) {
    }

    public function setMatchedRouteName(string $name): self
    {
        $this->matchedRouteName = $name;
        return $this;
    }

    public function getMatchedRouteName(): ?string
    {
        return $this->matchedRouteName;
    }

    public function setParams(array $params): self
    {
        $this->params = $params;
        return $this;
    }

    public function getParams(): ?array
    {
        return $this->params;
    }

    public function setParam(string $name, $value): self
    {
        $this->params[$name] = $value;
        return $this;
    }

    public function getParam(string $name, $default = null)
    {
        if (array_key_exists($name, $this->params)) {
            return $this->params[$name];
        }
        return $default;
    }
}
