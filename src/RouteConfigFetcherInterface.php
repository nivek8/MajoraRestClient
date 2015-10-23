<?php

namespace Majora\GuzzleRoutingManager;

interface RouteConfigFetcherInterface
{
    /**
     * @return array
     */
    public function fetch();
}
