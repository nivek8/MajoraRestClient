<?php

namespace Majora\RestClient\Route;

use GuzzleHttp\ClientInterface;
use Majora\RestClient\Exceptions\InvalidRouteConfigException;

class RouteConfigFetcherGuzzle implements RouteConfigFetcherInterface
{
    /**
     * @var ClientInterface
     */
    private $guzzleClient;

    /**
     * @param ClientInterface $guzzleClient
     * @param string          $routingUrl
     * @param string          $routingMethod
     */
    public function __construct(ClientInterface $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Majora\RestClient\Exceptions\InvalidRouteConfigException
     */
    public function fetch($routingUrl, $routingMethod = 'GET')
    {
        $guzzleResponse = $this->guzzleClient->request($routingMethod, $routingUrl);
        $convertJsonResponse = json_decode($guzzleResponse->getBody(), true);

        if (!isset($convertJsonResponse['routes'])) {
            throw new InvalidRouteConfigException('key "routes" not found');
        }

        return $convertJsonResponse['routes'];
    }
}
