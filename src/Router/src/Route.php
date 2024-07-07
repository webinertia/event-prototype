<?php

declare(strict_types=1);

namespace Router;

use InvalidArgumentException;
use Laminas\Stdlib\ArrayUtils;
use Psr\Http\Message\ServerRequestInterface;

use function array_filter;
use function array_keys;
use function array_key_exists;
use function in_array;
use function strtoupper;

final class Route implements RouterInterface
{
    public function __construct(
        public string $name,
        public string $actionClass,
        public array $methods,
        public ?array $query
    ) {
    }

    public static function factory(iterable $options): self
    {
        $name          = null;
        $actionClass   = null;
        $methods       = [];
        $query         = [];

        // if we have iterabe....
        $options = ArrayUtils::iteratorToArray($options);

        if (! array_key_exists('methods', $options)) {
            throw new InvalidArgumentException('route must define a http method array for which the route is valid.');
        }

        $methods = $options['methods'];

        if (! array_key_exists('name', $options)) {
            throw new InvalidArgumentException('route name key must be defined.');
        }

        $name = $options['name'];

        if (! array_key_exists('query', $options)) {
            throw new InvalidArgumentException('route must define a query key for the expected query string params');
        }

        $query = $options['query'];

        if (array_key_exists('action_class', $options)) {
            $actionClass = $options['action_class'];
        }

        return new static(
            $name,
            $actionClass,
            $methods,
            $query
        );
    }

    public function match(ServerRequestInterface $request): RouteResult|false
    {
        $requestQuery = $request->getQueryParams();
        $method = strtoupper($request->getMethod());

        if (! in_array($method, $this->methods)) {
            return false;
        }

        $paramKeys      = array_keys($requestQuery);
        if (ArrayUtils::isList($this->query) || ArrayUtils::hasNumericKeys($this->query, true)) {
            $routeQueryKeys = array_keys(array_flip($this->query));
        } elseif (ArrayUtils::hasStringKeys($this->query)) {
            $routeQueryKeys = array_keys($this->query);
        }

        if ($paramKeys === $routeQueryKeys && ! isset($this->query['action'])) {
            return new RouteResult($this->name, array_filter((array) $this));
        }

        if (! empty($this->query['action']) && $requestQuery === $this->query) {
            return new RouteResult($this->name, array_filter((array) $this));
        }
        return false;
    }
}
