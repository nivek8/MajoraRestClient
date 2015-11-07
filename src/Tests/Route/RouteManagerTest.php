<?php

namespace Majora\RestClient\Tests\Route;

use Majora\RestClient\Route\RouteManager;
use Majora\RestClient\Tests\Mock\MockRouteCollection;
use Majora\RestClient\Tests\Mock\MockGuzzleClient;

class RouteManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RouteManager
     */
    private $routeManager;

    /**
     * @inheritDoc
     */
    public function setUp()
    {
        $this->routeManager = new RouteManager(
            $this->mockRouteCollectionBuilder(),
            $this->mockRouteConfigFetcherGuzzle()
        );
    }

    /**
     * test load method
     */
    public function testLoad()
    {
        $this->routeManager->load('http://false.json');

        $this->assertAttributeInstanceOf(
            'Symfony\Component\Routing\RouteCollection',
            'routeCollection',
            $this->routeManager
        );
    }

    /**
     * test getRouteCollection before calling load method
     */
    public function testGetRouteCollectionBeforeLoading()
    {
        $this->assertNull($this->routeManager->getRouteCollection());
    }

    /**
     * test getRouteCollection after calling load method
     */
    public function testGetRouteCollectionAfterLoading()
    {
        $this->routeManager->load('http://false.json');

        $this->assertInstanceOf(
            'Symfony\Component\Routing\RouteCollection',
            $this->routeManager->getRouteCollection()
        );
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function mockRouteCollectionBuilder()
    {
        $mockCollectionBuilder = $this->getMockBuilder('Majora\RestClient\Route\RouteCollectionBuilder')
            ->disableOriginalConstructor()
            ->getMock();

        $mockCollectionBuilder->method('build')
            ->willReturn(MockRouteCollection::initRouteCollection());

        return $mockCollectionBuilder;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function mockRouteConfigFetcherGuzzle()
    {
        $mockRouteConfigFetcherGuzzle = $this->getMockBuilder('Majora\RestClient\Route\RouteConfigFetcherInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $mockRouteConfigFetcherGuzzle->method('fetch')
            ->willReturn(MockGuzzleClient::initConfig());

        return $mockRouteConfigFetcherGuzzle;
    }
}