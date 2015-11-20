<?php

namespace Majora\RestClient\Tests\Unit\Map;

use Majora\RestClient\Map\MapFileManager;
use Majora\RestClient\Tests\Mock\MockMapFileBuilder;

class MapFileManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MapFileManager
     */
    private $mapFileManager;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->mapFileManager = new MapFileManager(
        $this->mockMapFileFetcher()
        );
    }

    /**
     * test load method.
     */
    public function testLoad()
    {
        $this->mapFileManager->load('My\Namespace\Object\Path');

        $this->assertAttributeSame(
            MockMapFileBuilder::initMapFile()['My\Namespace\Object\Path'],
            'map',
            $this->mapFileManager
        );
    }

    /**
     * test getRouteName method.
     *
     *@dataProvider routeProvider
     */
    public function testGetRouteName($method, $routeName)
    {
        $this->mapFileManager->load('My\Namespace\Object\Path');
        $response = $this->mapFileManager->getRouteName($method);

        if ($routeName === 'my_object_cget') {
            $this->assertNotSame($routeName, $response);

            return;
        }

        $this->assertSame($routeName, $response);
    }

    /**
     * test routeExist method.
     *
     * @dataProvider routeProvider
     */
    public function testRouteExist($method, $routeName)
    {
        $this->mapFileManager->load('My\Namespace\Object\Path');
        $this->assertTrue($this->mapFileManager->routeExist($method, $routeName));
    }

    /**
     * test routeExist method with false route.
     */
    public function testRouteExistFailureRouteNameNotExist()
    {
        $this->mapFileManager->load('My\Namespace\Object\Path');
        $this->assertFalse($this->mapFileManager->routeExist('GET', 'my_false_route'));
    }

    /**
     * provider for testGetRouteName.
     *
     * @return array
     */
    public function routeProvider()
    {
        return array(
            array('get', 'my_object_get'),
            array('get', 'my_object_cget'),
            array('post', 'my_object_post'),
        );
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function mockMapFileFetcher()
    {
        $mockMapFileFetcher = $this->getMockBuilder('Majora\RestClient\Map\MapFileFetcherInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $mockMapFileFetcher->method('fetch')
            ->willReturn(MockMapFileBuilder::initMapFile()['My\Namespace\Object\Path']);

        return $mockMapFileFetcher;
    }
}
