<?php

namespace Majora\RestClient;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class Client
{
    /**
     * @var ClientInterface
     */
    private $guzzle;

    /**
     * @var string
     */
    private $routingUrl;

    /**
     * @var string
     */
    private $routingMethod;

    /**
     * @var RouteCollectionBuilder
     */
    private $routeCollectionBuilder;

    /**
     * @var RouteCollection
     */
    private $routeCollection;

    /**
     * @param string $routingUrl
     * @param string $routingMethod
     */
    public function __construct($routingUrl, $routingMethod = 'GET')
    {
        $this->guzzle = new GuzzleClient();
        $this->routingUrl = $routingUrl;
        $this->routingMethod = $routingMethod;
        $this->routeCollectionBuilder = new RouteCollectionBuilder();
        $this->init();
    }

    /**
     * @param $routeName
     * @return Route
     * @throws \Exception
     */
    public function request($routeName)
    {
        if (null === $this->routeCollection){
            throw new \Exception();
        }

        return $this->routeCollection->get($routeName);
    }

    /**
     * @return RouteCollection
     */
    private function init()
    {
        $routeConfig = $this->getGuzzleRouteConfig();
        $this->routeCollection = $this->routeCollectionBuilder->build($routeConfig);
    }

    /**
     * @return array
     * @throws \Exception
     */
    private function getGuzzleRouteConfig()
    {
        try {
            $guzzleResponse = $this->guzzle->request($this->routingMethod, $this->routingUrl);
            $convertJsonResponse = json_decode($guzzleResponse->getBody(), true);

            return $convertJsonResponse['routes'];
        }
        catch (\Exception $e) {
            throw $e;
        }
    }
}
