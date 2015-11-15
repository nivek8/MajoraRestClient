<?php

namespace Majora\RestClient\Rest;

use GuzzleHttp\ClientInterface;

class GuzzleRestClient implements RestClientInterface
{
    /**
     * @var ClientInterface
     */
    private $guzzleClient;

    /**
     * @param ClientInterface $guzzleClient
     */
    public function __construct(ClientInterface $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * @param string $method
     * @param string $routeName
     *
     * @return json
     */
    public function request($method, $url)
    {
        $response = $this->guzzleClient->request($method, $url)->getBody()->getContents();

        return $response;
    }

    /**
     * @param $method
     * @param $url
     *
     * @return json
     */
    public function asyncRequest($method, $url)
    {
        return $this->guzzleClient->requestAsync($method, $url)->getBody()->getContents();
    }
}
