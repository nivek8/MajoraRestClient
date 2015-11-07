<?php

namespace Majora\RestClient\Tests\Rest;

use Majora\RestClient\Rest\RestManager;

class RoutCollectionManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RestManager
     */
    private $restManager;

    /**
     * @inheritDoc
     */
    public function setUp()
    {
        $this->restManager = new RestManager(
            $this->mockRouteManager(),
            $this->mockMapFileManager()
        );
    }

    public function testGetRouteManager()
    {
        $this->assertSame(
            'Majora\RestClient\Route\RouteManager',
            $this->restManager->getRouteManager()
        );
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

        var_dump($mockMapFileManager);

        return $mockMapFileManager;
    }
}