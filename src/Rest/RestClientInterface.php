<?php

namespace Majora\RestClient\Rest;

interface RestClientInterface
{
    /**
     * @param string $method
     * @param string $url
     *
     * @return mixed
     */
    public function request($method, $url);
}
