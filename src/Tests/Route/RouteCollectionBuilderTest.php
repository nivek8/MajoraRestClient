<?php

namespace Majora\RestClient\Tests\Route;

use Majora\RestClient\Route\RouteCollectionBuilder;
use Majora\RestClient\Tests\Mock\MockGuzzleClient;

class RouteCollectionBuilderTest extends \PHPUnit_Framework_Testcase
{
    /**
     * @var RouteCollectionBuilder
     */
    private $routeCollectionBuilder;

    /**
     * @var array
     */
    private $config;

    /**
     * @inheritDoc
     */
    public function setUp()
    {
        $this->routeCollectionBuilder = new RouteCollectionBuilder();
        $this->config = MockGuzzleClient::initConfig();
    }

    /**
     * test build method.
     */
    public function testBuild()
    {
        $routeCollection = $this->routeCollectionBuilder->build($this->config);
        $this->assertInstanceOf('Symfony\Component\Routing\RouteCollection', $routeCollection);
        $this->assertInstanceOf('Symfony\Component\Routing\Route', $routeCollection->get(key($this->config)));
    }
}
