<?php

namespace Majora\RestClient\Tests;

use Majora\RestClient\Client;
use Majora\RestClient\Tests\Mock\MockGuzzleClient;
use Majora\RestClient\Tests\Mock\MockRouteCollection;

/**
 * Class ClientTest
 * @package Majora\RestClient\Tests
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Client
     */
    private $client;

    /**
     * setUp
     */
    public function setUp()
    {

       $this->client = new Client(
           $this->mockRouteConfigFetcherGuzzle(),
           $this->mockRouteCollectionBuilder(),
           $this->mockGuzzleClient()
       );
    }

    /**
     * test call method
     */
    public function testCall()
    {
        $result = $this->client->call('http://false.json');

        $this->assertAttributeInstanceOf(
            'Symfony\Component\Routing\RouteCollection',
            'routeCollection',
            $this->client
        );

        $this->assertSame($result, $this->client);
    }

    /**
     * test request method
     */
    public function testRequest()
    {
        $response = $this->client->call('http://false.json')->request('GET', 'my_route_name');
        $this->assertJson($response);
    }

    /**
     * test request method failure when routeCollection is null
     */
    public function testRequestFailureNoRouteCollectionLoaded()
    {
        $this->setExpectedException('Majora\RestClient\Exceptions\InvalidClientRouteCollectionException');
        $this->client->request('GET', 'my_route_name');
    }

    /**
     * test request method failure when request method is not allowed
     */
    public function testRequestFailureMethodNotAllowed()
    {
        $this->setExpectedException('Majora\RestClient\Exceptions\InvalidMethodRequestException');
        $this->client->call('http://false.json')->request('POST', 'my_route_name');
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function mockRouteConfigFetcherGuzzle()
    {
        $mockRouteConfigFetcherGuzzle = $this->getMockBuilder('Majora\RestClient\Route\RouteConfigFetcherInterface')
            ->enableOriginalConstructor()
            ->getMock();

        $mockRouteConfigFetcherGuzzle->method('fetch')
            ->willReturn(MockGuzzleClient::initConfig());

        return $mockRouteConfigFetcherGuzzle;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function mockRouteCollectionBuilder()
    {
        $mockCollectionBuilder = $this->getMockBuilder('Majora\RestClient\Route\RouteCollectionBuilder')
            ->enableOriginalConstructor()
            ->getMock();

        $mockCollectionBuilder->method('build')
            ->willReturn(MockRouteCollection::initRouteCollection());

        return $mockCollectionBuilder;
    }

    private function mockGuzzleClient()
    {
        $mockGuzzleClient = $this->getMockBuilder('GuzzleHttp\ClientInterface')
            ->enableOriginalConstructor()
            ->getMock();

        $mockGuzzleClient->method('request')
            ->willReturn(MockGuzzleClient::initGuzzleRestResponse());

        return $mockGuzzleClient;
    }
}
