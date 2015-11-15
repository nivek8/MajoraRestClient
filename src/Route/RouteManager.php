<?php

namespace Majora\RestClient\Route;

use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RequestContext;
use Majora\RestClient\Exceptions\InvalidRouteCollectionException;
use Majora\RestClient\Exceptions\InvalidRouteUrlParametersException;

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
     * @var UrlGenerator
     */
    private $urlGenerator;

    /**
     * RouteManager constructor.
     *
     * @param \Majora\RestClient\Route\RouteCollectionBuilder      $routeCollectionBuilder
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
     * load routeCollection from url.
     *
     * @param string $url
     */
    public function load($url)
    {
        $routeConfig = $this->routeConfigFetcher->fetch($url);
        $this->routeCollection = $this->routeCollectionBuilder->build($routeConfig);
        $this->urlGenerator = new UrlGenerator($this->routeCollection, new RequestContext());
    }

    /**
     * generate url.
     *
     * @param string $routeName
     * @param array  $routeParameters
     *
     * @return string
     */
    public function generateUrl($routeName, $routeParameters = array())
    {
        if (null === $this->routeCollection) {
            throw new InvalidRouteCollectionException();
        }

        if (!is_array($routeParameters)) {
            throw new InvalidRouteUrlParametersException();
        }

        return $this->urlGenerator->generate($routeName, $routeParameters, true);
    }
}
