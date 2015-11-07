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
            $this->mockRestManager(),
            $this->mockGuzzleClient(),
            'http://false.json'
       );
    }

    /**
     * test call method.
     */
    public function testCall()
    {
        $this->markTestSkipped();

        $result = $this->client->call('http://false.json');

        $this->assertAttributeInstanceOf(
            'Symfony\Component\Routing\RouteCollection',
            'routeCollection',
            $this->client
        );

        $this->assertSame($result, $this->client);
    }

    /**
     * data for testRequest method.
     *
     * @return array
     */
    public function requestDataProvider()
    {
        return array(
            array('GET', 'my_route_cget', array()),
            array('GET', 'my_route_get', array('id' => 1)),
            array('POST', 'my_route_post', array()),
            array('PUT', 'my_route_put', array('id' => 1)),
            array('DELETE', 'my_route_delete', array('id' => 1)),
            array('PATCH', 'my_route_patch', array('id' => 1)),
            array('HEAD', 'my_route_head', array('id' => 1)),
        );
    }

    /**
     * test request method.
     *
     * @dataProvider requestDataProvider
     */
    public function testRequest($method, $routeName, $param)
    {
        $this->markTestSkipped();
        $response = $this->client->call('http://false.json')->request($method, $routeName, $param);
        $this->assertJson($response);
    }

    /**
     * test request method failure when a require parameter is missing.
     */
    public function testRequestFailureParamRequireMissing()
    {
        $this->markTestSkipped();
        $this->setExpectedException(
            'Symfony\Component\Routing\Exception\MissingMandatoryParametersException',
            'Some mandatory parameters are missing ("id") to generate a URL for route "my_route_get".'
        );

        $this->client->call('http://false.json')->request('GET', 'my_route_get');
    }

    /**
     * test request method failure when routeName does not exist.
     */
    public function testRequestFailureRouteNameNotExist()
    {
        $this->markTestSkipped();
        $this->setExpectedException(
            'Symfony\Component\Routing\Exception\RouteNotFoundException',
            'Unable to generate a URL for the named route "false_route_name" as such route does not exist.'
        );

        $this->client->call('http://false.json')->request('GET', 'false_route_name');
    }

    /**
     * test request method failure when routeCollection is null.
     */
    public function testRequestFailureNoRouteCollectionLoaded()
    {
        $this->markTestSkipped();
        $this->setExpectedException('Majora\RestClient\Exceptions\InvalidClientRouteCollectionException');
        $this->client->request('GET', 'my_route_name');
    }

    /**
     * test request method failure when request method is not allowed.
     */
    public function testRequestFailureMethodNotAllowed()
    {
        $this->markTestSkipped();
        $this->setExpectedException('Majora\RestClient\Exceptions\InvalidMethodRequestException');
        $this->client->call('http://false.json')->request('POST', 'my_route_cget');
    }

    /**
     * test get method.
     */
    public function testGet()
    {
        $this->markTestSkipped();
        $response = $this->client->call('http://false.json')->get('my_route_cget');
        $this->assertJson($response);
    }

    /**
     * test post method.
     */
    public function testPost()
    {
        $this->markTestSkipped();
        $response = $this->client->call('http://false.json')->post('my_route_post');
        $this->assertJson($response);
    }

    /**
     * test put method.
     */
    public function testPut()
    {
        $this->markTestSkipped();
        $response = $this->client->call('http://false.json')->put('my_route_put', array('id' => 1));
        $this->assertJson($response);
    }

    /**
     * test delete method.
     */
    public function testDelete()
    {
        $this->markTestSkipped();
        $response = $this->client->call('http://false.json')->delete('my_route_delete', array('id' => 1));
        $this->assertJson($response);
    }

    /**
     * test patch method.
     */
    public function testPatch()
    {
        $this->markTestSkipped();
        $response = $this->client->call('http://false.json')->patch('my_route_patch', array('id' => 1));
        $this->assertJson($response);
    }

    /**
     * test head method.
     */
    public function testHead()
    {
        $this->markTestSkipped();
        $response = $this->client->call('http://false.json')->head('my_route_head', array('id' => 1));
        $this->assertJson($response);
    }

    private function mockRestManager()
    {
        $mockRouteCollectionManager = $this->getMockBuilder('Majora\RestClient\Rest\RestManager')
            ->disableOriginalConstructor()
            ->getMock();

        return $mockRouteCollectionManager;
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
