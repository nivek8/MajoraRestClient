<?php

namespace Majora\RestClient\Map;

class MapFileManager
{
    /**
     * @var MapFileFetcherInterface
     */
    private $mapFileFetcher;

    /**
     * @var array
     */
    private $map;

    /**
     * MapFileManager constructor.
     *
     * @param MapFileFetcherInterface $mapFileFetcher
     */
    public function __construct(MapFileFetcherInterface $mapFileFetcher)
    {
        $this->mapFileFetcher = $mapFileFetcher;
    }

    /**
     * @param string $namespace
     */
    public function load($namespace)
    {
        $this->map = $this->mapFileFetcher->fetch($namespace);
    }

    /**
     * @param $method
     *
     * @return mixed
     */
    public function getRouteName($method)
    {
        $routeName = $this->map[strtoupper($method)];

        if (is_array($routeName)) {
            return $routeName[0];
        }

        return $routeName;
    }

    public function routeExist($method, $routeName)
    {
        $mapMethod = $this->map[strtoupper($method)];

        if (is_array($mapMethod)) {
            return in_array($routeName, $mapMethod);
        }

        return $mapMethod === $routeName;
    }
}
