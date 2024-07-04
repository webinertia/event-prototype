<?php

declare(strict_types=1);

namespace Router;

use Psr\Http\Message\ServerRequestInterface;

interface RouterInterface
{
    /**
     * Priority used for route stacks.
     *
     * @var int
     * public $priority;
     */

    /**
     * Create a new route with given options.
     *
     * @param array $options
     * @return RouteInterface
     */
    public static function factory(iterable $options);

    /**
     * Match a given request.
     *
     * @return RouteResult|bool
     */
    public function match(ServerRequestInterface $request): RouteResult|false;

    /**
     * Assemble the route.
     *
     * @param  array $params
     * @param  array $options
     * @return mixed
     */
    //public function assemble(array $params = [], array $options = []);
}
