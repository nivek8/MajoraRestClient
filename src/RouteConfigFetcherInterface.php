<?php

namespace Majora\RestClient;

interface RouteConfigFetcherInterface
{
    /**
     * @param $routingUrl
     * @param string $routingMethod
     * @return mixed
     */
    public function fetch($routingUrl, $routingMethod = 'GET');
}
