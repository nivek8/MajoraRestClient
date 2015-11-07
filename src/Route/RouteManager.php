<?php

namespace Majora\RestClient\Route;

use Majora\RestClient\Route\RouteCollectionBuilder;
use Majora\RestClient\Route\RouteConfigFetcherInterface;

class RouteManager
{
    /**
     * @var RouteCollectionBuilder
     */
    private $routeCollectionBuilder;

    /**
     * @var RouteConfigFetcher
     */
    private $routeConfigFetcher;

    /**
     * @var RouteCollection
     */
    private $routeCollection;

    /**
     * RouteManager constructor.
     * @param \Majora\RestClient\Route\RouteCollectionBuilder $routeCollectionBuilder
     * @param \Majora\RestClient\Route\RouteConfigFetcherInterface $routeConfigFetcher
     */
    public function __construct(
        RouteCollectionBuilder $routeCollectionBuilder,
        RouteConfigFetcherInterface $routeConfigFetcher
    ) {
        $this->routeCollectionBuilder = $routeCollectionBuilder;
        $this->routeConfigFetcher = $routeConfigFetcher;
    }

    /**
     * load routeCollection from url
     * @param string $url
     */
    public function load($url)
    {
        $routeConfig = $this->routeConfigFetcher->fetch($url);
        $this->routeCollection = $this->routeCollectionBuilder->build($routeConfig);
    }

    /**
     * get RouteCollection
     */
    public function getRouteCollection()
    {
        return $this->routeCollection;
    }
}
