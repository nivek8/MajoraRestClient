<?php

namespace Majora\GuzzleRoutingManager\Tests;

use Majora\GuzzleRoutingManager\RouteCollectionBuilder;

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
     * setUp
     */
    public function setUp()
    {
        $this->routeCollectionBuilder = new RouteCollectionBuilder();
        $this->config = $this->initConig();
    }

    /**
     * test build method
     */
    public function testBuild()
    {
        $routeCollection = $this->routeCollectionBuilder->build($this->config);

        $this->assertInstanceOf('Symfony\Component\Routing\RouteCollection', $routeCollection);
        $this->assertInstanceOf('Symfony\Component\Routing\Route', $routeCollection->get(key($this->config)));
    }

    /**
     * Init default value to test RouteCollectionValue
     * @return array
     */
    private function initConig()
    {
        return array(
            'test_routing' => array(
                'tokens' => array(
                    array("variable", "/", "[^/]++","id"),
                    array("text", "/api/partners"),
                ),
                'defaults' => array(),
                'requirements' => array('_method' => "PUT"),
                'hosttokens' => array(
                  array("text", "api.sir.dev"),
                ),
            ),
        );
    }
}
