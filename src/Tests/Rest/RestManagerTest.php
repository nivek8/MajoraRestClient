<?php

namespace Majora\RestClient\Tests\Rest;

use Majora\RestClient\Rest\RestManager;

class RestManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RestManager
     */
    private $restManager;

    /**
     * @var RouteManager
     */
    private $mockRouteManager;

    /**
     * @var MapFileManager
     */
    private $mockMapFileManager;

    /**
     * @var RestClientInterface
     */
    private $mockRestClient;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->mockRouteManager = $this->mockRouteManager();
        $this->mockMapFileManager = $this->mockMapFileManager();
        $this->mockRestClient = $this->mockRestClient();

        $this->restManager = new RestManager(
            $this->mockRouteManager,
            $this->mockMapFileManager,
            $this->mockRestClient,
            'http://www.false.json'
        );
    }

    /**
     * test call method.
     */
    public function testCall()
    {
        $this->mockMapFileManager
            ->expects($this->once())
            ->method('load')
            ->with('My\Namespace\Object\Path');

        $response = $this->restManager->call('My\Namespace\Object\Path');
        $this->assertSame($this->restManager, $response);
    }

    /**
     * test get method.
     */
    public function testGet()
    {
        $response = $this->restManager->call('My\Namespace\Object\Path')->get();
        $this->assertJson($response);
    }

    /**
     * test get method without.
     */
    public function testGetWithRouteName()
    {
        $this->mockMapFileManager->method('routeExist')
            ->willReturn(false);

        $this->setExpectedException('Majora\RestClient\Exceptions\InvalidRouteNameException');

        $this->restManager->call('My\Namespace\Object\Path')->get(array(), 'toto');
    }

    /**
     * test post method.
     */
    public function testPost()
    {
        $response = $this->restManager->call('My\Namespace\Object\Path')->post();
        $this->assertJson($response);
    }

    /**
     * test put method.
     */
    public function testPut()
    {
        $response = $this->restManager->call('My\Namespace\Object\Path')->put();
        $this->assertJson($response);
    }

    /**
     * test delete method.
     */
    public function testDelete()
    {
        $response = $this->restManager->call('My\Namespace\Object\Path')->delete();
        $this->assertJson($response);
    }

    /**
     * test head method.
     */
    public function testHead()
    {
        $response = $this->restManager->call('My\Namespace\Object\Path')->head();
        $this->assertJson($response);
    }

    /**
     * test patch method.
     */
    public function testPatch()
    {
        $response = $this->restManager->call('My\Namespace\Object\Path')->patch();
        $this->assertJson($response);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function mockRouteManager()
    {
        $mockRouteManager = $this->getMockBuilder('Majora\RestClient\Route\RouteManager')
            ->disableOriginalConstructor()
            ->getMock();

        return $mockRouteManager;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function mockMapFileManager()
    {
        $mockMapFileManager = $this->getMockBuilder('Majora\RestClient\Map\MapFileManager')
            ->disableOriginalConstructor()
            ->getMock();

        return $mockMapFileManager;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function mockRestClient()
    {
        $mockGuzzleClient = $this->getMockBuilder('Majora\RestClient\Rest\RestClientInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $mockGuzzleClient->method('request')
            ->willReturn('{"json": {"test": "test"}}');

        return $mockGuzzleClient;
    }
}
