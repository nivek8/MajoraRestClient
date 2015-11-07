<?php

namespace Majora\RestClient;

use GuzzleHttp\ClientInterface;
use Majora\RestClient\Exceptions\InvalidClientRouteCollectionException;
use Majora\RestClient\Exceptions\InvalidMethodRequestException;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Majora\RestClient\Route\RouteConfigFetcherInterface;
use Majora\RestClient\Route\RouteCollectionBuilder;

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
     * @var ClientInterface
     */
    private $guzzleClient;

    /**
     * @var RouteCollection
     */
    private $routeCollection;

    /**
     * @param RouteConfigFetcherInterface $routeConfigFetcher
     * @param RouteCollectionBuilder      $routeCollectionBuilder
     * @param ClientInterface             $guzzleClient
     */
    public function __construct(
        RouteConfigFetcherInterface $routeConfigFetcher,
        RouteCollectionBuilder $routeCollectionBuilder,
        ClientInterface $guzzleClient
    ) {
        $this->routeConfigFetcher = $routeConfigFetcher;
        $this->routeCollectionBuilder = $routeCollectionBuilder;
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * @param string $method
     * @param string $routeName
     * @param array  $parameters
     * @return json
     */
    public function request($method, $routeName, $parameters = array())
    {
        if (null === $this->routeCollection) {
            throw new InvalidClientRouteCollectionException();
        }

        $urlGenerator = new UrlGenerator($this->routeCollection, new RequestContext());
        $url = $urlGenerator->generate($routeName, $parameters, true);

        $route = $this->routeCollection->get($routeName);

        if (!in_array($method, $route->getMethods())) {
            throw new InvalidMethodRequestException();
        }

        $response = $this->guzzleClient->request($method, $url)->getBody()->getContents();

        return $response;
    }

    /**
     * @param string $routeName
     * @param array $parameters
     * @return json
     */
    public function get($routeName, $parameters = array())
    {
        return $this->request('GET', $routeName, $parameters);
    }

    /**
     * @param $routeName
     * @param array $parameters
     * @return json
     */
    public function post($routeName, $parameters = array())
    {
        return $this->request('POST', $routeName, $parameters);
    }

    /**
     * @param string $url
     *
     * @return self $this
     */
    public function call($url)
    {
        $routeConfig = $this->routeConfigFetcher->fetch($url);
        $this->routeCollection = $this->routeCollectionBuilder->build($routeConfig);

        return $this;
    }
}
