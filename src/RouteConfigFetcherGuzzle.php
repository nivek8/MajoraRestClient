<?php

namespace Majora\RestClient;

use GuzzleHttp\ClientInterface;
use Majora\RestClient\Exceptions\InvalidRouteConfigException;

class RouteConfigFetcherGuzzle implements RouteConfigFetcherInterface
{
    /**
     * @var ClientInterface
     */
    private $guzzleClient;

    /**
     * @var string
     */
    private $routingUrl;

    /**
     * @var string
     */
    private $routingMethod;

    /**
     * @param ClientInterface $guzzleClient
     * @param string $routingUrl
     * @param string $routingMethod
     */
    public function __construct(ClientInterface $guzzleClient, $routingUrl, $routingMethod = 'GET')
    {
        $this->guzzleClient = $guzzleClient;
        $this->routingUrl = $routingUrl;
        $this->routingMethod = $routingMethod;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Majora\RestClient\Exceptions\InvalidRouteConfigException
     */
    public function fetch()
    {
        $guzzleResponse = $this->guzzleClient->request($this->routingMethod, $this->routingUrl);
        $convertJsonResponse = json_decode($guzzleResponse->getBody(), true);

        if (!isset($convertJsonResponse['routes'])) {
            throw new InvalidRouteConfigException('key "routes" not found');
        }

        return $convertJsonResponse['routes'];
    }
}
