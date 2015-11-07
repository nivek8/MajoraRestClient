<?php

namespace Majora\RestClient\Rest;

use GuzzleHttp\ClientInterface;

class GuzzleRestClient
{
    /**
     * @var ClientInterface
     */
    private $guzzleClient;

    /**
     * @param ClientInterface $guzzleClient
     */
    public function construct(ClientInterface $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * @param string $method
     * @param string $routeName
     * @param array  $parameters
     *
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
}