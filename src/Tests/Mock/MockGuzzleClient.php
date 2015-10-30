<?php

namespace Majora\RestClient\Tests\Mock;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;

abstract class MockGuzzleClient
{
    /**
     * Init default value to test RouteCollectionValue.
     *
     * @return array
     */
    public static function initConfig()
    {
        return array(
            'test_routing' => array(
                'tokens' => array(
                    array('variable', '/', '[^/]++', 'id'),
                    array('text', '/api/partners'),
                ),
                'defaults' => array(),
                'requirements' => array('_method' => 'GET'),
                'hosttokens' => array(
                    array('text', 'api.sir.dev'),
                ),
            ),
        );
    }

    /**
     * Init default guzzle response.
     *
     * @return array
     */
    public static function initGuzzleResponse()
    {
        return array(
            'base_url' => 'base_url',
            'routes' => self::initConfig(),
            'prefix' => '',
            'host' => 'base.url.dev',
            'scheme' => 'http',
        );
    }

    /**
     * init default rest response.
     *
     * @return string
     */
    public static function initGuzzleRestResponse()
    {
        $handle = fopen('php://temp', 'w+');
        fwrite($handle, json_encode(self::initConfig()));
        $stream = new Stream($handle);

        $response = new Response('200', array(), $stream);

        return $response;
    }
}
