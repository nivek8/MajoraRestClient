<?php

namespace Majora\RestClient;

interface RouteConfigFetcherInterface
{
    /**
     * @return array
     */
    public function fetch();
}
