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
     * @param string $url
     *
     * @return string
     */
    public function request($method, $url)
    {
        return $this->guzzleClient->request($method, $url)->getBody()->getContents();
    }

    /**
     * @param $method
     * @param $url
     *
     * @return string
     */
    public function asyncRequest($method, $url)
    {
        return $this->guzzleClient->requestAsync($method, $url)->getBody()->getContents();
    }
}
