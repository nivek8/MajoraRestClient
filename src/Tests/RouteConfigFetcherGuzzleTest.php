<?php

namespace Majora\RestClient\Tests;

use Majora\RestClient\RouteConfigFetcherGuzzle;
use Majora\RestClient\Tests\Mock\MockGuzzleClient;

/**
 * Class RouteConfigFetcherGuzzleTest
 * @package Majora\RestClient\Tests
 */
class RouteConfigFetcherGuzzleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $responseContent;

    /**
     * setUp
     */
    public function setUp()
    {
        $this->responseContent = MockGuzzleClient::initGuzzleResponse();
    }

    /**
     * test fetch method
     */
    public function testFetch()
    {
        $routeConfigFetcherGuzzle= $this->initRouteConfigFetcherGuzzle();
        $response = $routeConfigFetcherGuzzle->fetch();

        $this->assertSame(
            MockGuzzleClient::initConfig(),
            $response
        );
    }

    /**
     * test fetch method Exception "no route"
     */
    public function testFetchFailureNoRoute()
    {
        $this->responseContent = array();
        $routeConfigFetcherGuzzle= $this->initRouteConfigFetcherGuzzle();

        $this->setExpectedException(
            '\Majora\RestClient\Exceptions\InvalidRouteConfigException',
            'key "routes" not found'
        );

        $routeConfigFetcherGuzzle->fetch();
    }

    /**
     * init routeConfigFetcherGuzzle
     */
    private function initRouteConfigFetcherGuzzle()
    {
        return new RouteConfigFetcherGuzzle(
            $this->mockGuzzleClient(),
            'http://false_url.json'
        );
    }

    /**
     * Mock guzzle client
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function mockGuzzleClient()
    {
        $guzzleClient = $this->getMockBuilder('GuzzleHttp\ClientInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $guzzleClient->method('request')
            ->willReturn($this->mockGuzzleResponse());

        return $guzzleClient;
    }

    /**
     * Mock guzzle Response
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function mockGuzzleResponse()
    {
        $guzzleResponse = $this->getMockBuilder('GuzzleHttp\Psr7\Response')
            ->disableOriginalConstructor()
            ->getMock();

        $guzzleResponse->method('getBody')
            ->willReturn(json_encode($this->responseContent));

        return $guzzleResponse;
    }
}