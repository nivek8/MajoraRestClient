<?php

namespace Majora\RestClient\Route;

interface RouteConfigFetcherInterface
{
    /**
     * @param $routingUrl
     * @param string $routingMethod
     *
     * @return mixed
     */
    public function fetch($routingUrl, $routingMethod = 'GET');
}
