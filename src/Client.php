<?php

namespace Majora\RestClient;

use Majora\RestClient\RouteConfigFetcherInterface;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class Client
{
    /**
     * @var RouteCollectionBuilder
     */
    private $routeCollectionBuilder;

    /**
     * @var RouteConfigFetcherInterface
     */
    private $routeConfigFetcher;

    /**
     * @var RouteCollection
     */
    private $routeCollection;

    /**
     * @param RouteConfigFetcherInterface $routeConfigFetcher
     * @param RouteCollectionBuilder $routeCollectionBuilder
     */
    public function __construct(
        RouteConfigFetcherInterface $routeConfigFetcher,
        RouteCollectionBuilder $routeCollectionBuilder
    )
    {
        $this->routeConfigFetcher = $routeConfigFetcher;
        $this->routeCollectionBuilder = $routeCollectionBuilder;
    }

    /**
     * @param $routeName
     * @return Route
     */
    public function request($method, $routeName, $parameters)
    {
        $urlGenerator = new UrlGenerator($this->routeCollection, new RequestContext());
        $url = $urlGenerator->generate($routeName, $parameters);

        $route = $this->routeCollection->get($routeName);

        if (!in_array($method, $route->getMethods())) {
            //@todo throw exception
        }
    }

    /**
     * load route collection
     * @return void
     */
    private function call($url)
    {
        $routeConfig = $this->routeConfigFetcher->fetch($url);
        $this->routeCollection = $this->routeCollectionBuilder->build($routeConfig);
    }
}
