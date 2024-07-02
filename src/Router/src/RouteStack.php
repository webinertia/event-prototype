<?php

declare(strict_types=1);

namespace Router;

use Laminas\Stdlib\ArrayUtils;
use Laminas\Stdlib\PriorityList;
use Psr\Http\Message\ServerRequestInterface;

use function is_object;

final class RouteStack implements RouteStackInterface
{
    private array $defaultParams = [];

    public function __construct(
        private PriorityList $routes = new PriorityList(),
    ) {

    }

    public function addRoute($name, RouterInterface|iterable $route, $priority = null): self
    {
        if (! $route instanceof RouterInterface) {
            $route = $this->routeFromArray(ArrayUtils::iteratorToArray($route));
        }

        if ($priority === null && isset($route->priority)) {
            $priority = $route->priority;
        }

        $this->routes->insert($route->name, $route, $priority);

        return $this;
    }

    public function addRoutes(iterable $routes): self
    {
        foreach ($routes as $route) {
            if (isset($route['priority'])) {
                $this->addRoute($route['name'], $route, $route['priority']);
                continue;
            }
            $this->addRoute($route['name'], $route);
        }

        return $this;
    }

    public function removeRoute($name): self
    {
        $this->routes->remove($name);
        return $this;
    }

    public function hasRoute(string $name): bool
    {
        return $this->routes->get($name) !== null;
    }

    public function getRoute(string $name): RouterInterface
    {
        return $this->routes->get($name);
    }

    public function setRoutes(iterable $routes): self
    {
        $this->routes->clear();
        $routes = ArrayUtils::iteratorToArray($routes);
        $this->addRoutes($routes);
        return $this;
    }

    public static function factory(iterable $config): RouterInterface
    {
        $router = new static();
        if (isset($config['routes'])) {
            $router->addRoutes($config['routes']);
        }

        return $router;
    }

    public function match(ServerRequestInterface $request): RouteResult|false
    {
        foreach ($this->routes as $name => $route) {
            /** @var RouteResult $match */
            if (($match = $route->match($request)) instanceof RouteResult) {
                $match->setMatchedRouteName($name);

                // todo: fully implement default param support
                foreach($this->defaultParams as $param => $value) {
                    if ($match->getParam($param) === null) {
                        $match->setParam($param, $value);
                    }
                }
                return $match;
            }
        }
        return false;
    }

    public function routeFromArray(iterable $spec): RouterInterface
    {
        return Route::factory($spec);
    }

    public function setDefaultParams(array $params): self
    {
        $this->defaultParams = $params;
        return $this;
    }

    public function setDefaultParam(string $name, $value): self
    {
        $this->defaultParams[$name] = $value;
        return $this;
    }
}
