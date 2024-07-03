<?php

declare(strict_types=1);

namespace Router;

use InvalidArgumentException;
use Laminas\Diactoros\ServerRequest;
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
        public array $methods,
        public string $name,
        public string $actionClass,
        public ?string $action       = null,
        public ?array $subActions    = [],
        public ?string $area         = null,
        public ?string $board        = null,
        public ?array $defaultParams = [],
        public ?int $priority        = null,
        public ?string $sa           = null,
        public ?string $topic        = null
    ) {
    }

    public static function factory(iterable $options): self
    {
        $methods       = [];
        $name          = null;
        $actionClass   = null;
        $action        = null;
        $subActions    = [];
        $area          = null;
        $board         = null;
        $defaultParams = [];
        $priority      = null;
        $sa            = null;
        $topic         = null;

        // if we have iterabe....
        $options = ArrayUtils::iteratorToArray($options);

        if (! array_key_exists('methods', $options)) {
            throw new InvalidArgumentException('route must define a http method arrar for which the route is valid.');
        }

        $methods = $options['methods'];

        if (! array_key_exists('name', $options)) {
            throw new InvalidArgumentException('route name key must be defined.');
        }

        $name = $options['name'];

        if (array_key_exists('actionClass', $options)) {
            $actionClass = $options['actionClass'];
        }

        if (array_key_exists('action', $options)) {
            $action = $options['action'];
        }

        if (array_key_exists('area', $options)) {
            $area = $options['area'];
        }

        if (array_key_exists('board', $options)) {
            $board = $options['board'];
        }

        if (array_key_exists('default_params', $options)) {
            $defaultParams = $options['default_params'];
        }

        if (array_key_exists('priority', $options)) {
            $priority = (int) $options['priority'];
        }

        if (array_key_exists('sa', $options)) {
            $sa = $options['sa'];
        }

        if (array_key_exists('sub_actions', $options)) {
            $subActions = $options['sub_actions'];
        }

        if (array_key_exists('topic', $options)) {
            $topic = $options['topic'];
        }

        return new static(
            $methods,
            $name,
            $actionClass,
            $action,
            $subActions,
            $area,
            $board,
            $defaultParams,
            $priority,
            $sa,
            $topic
        );
    }

    public function match(ServerRequestInterface $request): RouteResult|false
    {
        $params = $request->getQueryParams();
        $method = strtoupper($request->getMethod());

        $routeParams = array_filter((array) $this);
        if (! in_array($method, $routeParams['methods'])) {
            return false;
        }

        if (isset($params['sa']) && ($params['sa'] !== $routeParams['sa']) || ! in_array($params['sa'], $routeParams['sub_actions'])) {
            return false;
        }

        unset(
            $routeParams['methods'],
            $routeParams['default_params'],
            $routeParams['name'],
            $routeParams['actionClass'],
            $routeParams['sub_actions']
        );

        $paramKeys      = array_keys($params);
        $routeParamKeys = array_keys($routeParams);

        if ($paramKeys === $routeParamKeys) {
            return new RouteResult($this->name, array_filter((array) $this));
        }
        return false;
    }
}
