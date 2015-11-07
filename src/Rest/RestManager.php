<?php

namespace Majora\RestClient\Rest;

use Majora\RestClient\Route\RouteManager;
use Majora\RestClient\Map\MapFileManager;

class RestManager
{
    /**
     * @var RouteManager
     */
    private $routeManager;

    /**
     * @var MapManager
     */
    private $mapFileManager;

    /**
     * RestManager constructor.
     * @param RouteManager $routeManager
     */
    public function __construct(
        RouteManager $routeManager,
        MapFileManager $mapFileManager
    ) {
        $this->routeManager = $routeManager;
        $this->mapFileManager = $mapFileManager;
    }
}