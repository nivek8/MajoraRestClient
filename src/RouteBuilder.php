<?php

namespace Majora\GuzzleRoutingManager;


class RouteBuilder
{

    /**
     * @var \ArrayAccess
     */
    private $routingConfigRegistry;

    /**
     * @param \ArrayAccess $routingConfigRegistry
     */
    public function __construct(\ArrayAccess $routingConfigRegistry)
    {
        $this->$routingConfigRegistry = $routingConfigRegistry;
    }

    /**
     * @param $routeName
     * @param array $options
     * @return Route
     */
    public function build($routeName, array $options)
    {
        if ($this->routingConfigRegistry->offsetExists($routeName)) {
            throw new \RuntimeException('Route not found: ' .$routeName);
        }

        $routeconfig = $this->routingConfigRegistry->offsetGet($routeName);

        return $route;
    }
}