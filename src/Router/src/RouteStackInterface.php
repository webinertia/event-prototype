<?php

declare(strict_types=1);

namespace Router;

interface RouteStackInterface extends RouterInterface
{
    /**
     * Add a route to the stack.
     *
     * @param string          $name
     * @param iterable|TRoute $route
     * @param int             $priority
     * @return static
     */
    public function addRoute(string $name, iterable $route, ?int $priority = null): self;

    /**
     * Add multiple routes to the stack.
     */
    public function addRoutes(iterable $routes): self;

    /**
     * Remove a route from the stack.
     */
    public function removeRoute(string $name): self;

    /**
     * Remove all routes from the stack and set new ones.
     */
    public function setRoutes(iterable $routes): self;
}
