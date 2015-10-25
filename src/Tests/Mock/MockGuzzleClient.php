<?php

namespace Majora\RestClient\Tests\Mock;

abstract class MockGuzzleClient
{
    /**
     * Init default value to test RouteCollectionValue
     * @return array
     */
    static public function initConfig()
    {
        return array(
            'test_routing' => array(
                'tokens' => array(
                    array("variable", "/", "[^/]++", "id"),
                    array("text", "/api/partners"),
                ),
                'defaults' => array(),
                'requirements' => array('_method' => "PUT"),
                'hosttokens' => array(
                    array("text", "api.sir.dev"),
                ),
            ),
        );
    }

    /**
     * Init
     * @return array
     */
    static public function initGuzzleResponse()
    {
        return array(
            "base_url" => "base_url",
            "routes" => self::initConfig(),
            "prefix" => "",
            "host" => "base.url.dev",
            "scheme" => "http",
        );
    }
}