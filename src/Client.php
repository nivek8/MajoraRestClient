<?php

namespace Majora\RestClient;

use GuzzleHttp\ClientInterface;
use Majora\RestClient\Exceptions\InvalidClientRouteCollectionException;
use Majora\RestClient\Exceptions\InvalidMethodRequestException;
use Majora\RestClient\Rest\RestManager;
use Majora\RestClient\Route\RouteCollectionManager;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RequestContext;

class Client
{
    /**
     * @var RestManager
     */
    private $restManager;

    /**
     * @param RouteCollectionManager $routeCollectionManager
     * @param ClientInterface $guzzleClient
     * @param string $url
     */
    public function __construct(
        RestManager $restManager,
        $url
    ) {
        $this->restManager = $restManager;
    }
}
