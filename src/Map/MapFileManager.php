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
     * @return array
     */
    public function getMap()
    {
        return $this->map;
    }
}