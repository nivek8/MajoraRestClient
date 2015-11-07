<?php

namespace Majora\RestClient\Tests;

use Majora\RestClient\Client;
use Majora\RestClient\Tests\Mock\MockGuzzleClient;
use Majora\RestClient\Tests\Mock\MockRouteCollection;

/**
 * Class ClientTest.
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Client
     */
    private $client;

    /**
     * setUp.
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
     * test call method.
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
     * data for testRequest method
     *
     * @return array
     */
    public function requestDataProvider()
    {
        return array(
            array('GET', 'my_route_cget', array()),
            array('GET', 'my_route_get', array('id' => 1)),
            array('POST', 'my_route_post', array()),
        );
    }

    /**
     * test request method.
     * @dataProvider requestDataProvider
     */
    public function testRequest($method, $routeName, $param)
    {
        $response = $this->client->call('http://false.json')->request($method, $routeName, $param);
        $this->assertJson($response);
    }

    /**
     * test request method failure when a require parameter is missing.
     */
    public function testRequestFailureParamRequireMissing()
    {
        $this->setExpectedException(
            'Symfony\Component\Routing\Exception\MissingMandatoryParametersException',
            'Some mandatory parameters are missing ("id") to generate a URL for route "my_route_get".'
        );

        $this->client->call('http://false.json')->request('GET', 'my_route_get');
    }

    /**
     * test request method failure when routeName does not exist
     */
    public function testRequestFailureRouteNameNotExist()
    {
        $this->setExpectedException(
            'Symfony\Component\Routing\Exception\RouteNotFoundException',
            'Unable to generate a URL for the named route "false_route_name" as such route does not exist.'
        );

        $this->client->call('http://false.json')->request('GET', 'false_route_name');
    }

    //TODO essayer route qui n'existe pas

    /**
     * test request method failure when routeCollection is null.
     */
    public function testRequestFailureNoRouteCollectionLoaded()
    {
        $this->setExpectedException('Majora\RestClient\Exceptions\InvalidClientRouteCollectionException');
        $this->client->request('GET', 'my_route_name');
    }

    /**
     * test request method failure when request method is not allowed.
     */
    public function testRequestFailureMethodNotAllowed()
    {
        $this->setExpectedException('Majora\RestClient\Exceptions\InvalidMethodRequestException');
        $this->client->call('http://false.json')->request('POST', 'my_route_cget');
    }

    /**
     * test get method
     */
    public function testGet()
    {
        $response = $this->client->call('http://false.json')->get('my_route_cget');
        $this->assertJson($response);
    }

    public function testPost()
    {
        $response = $this->client->call('http://false.json')->post('my_route_post');
        $this->assertJson($response);
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

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
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
