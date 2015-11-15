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
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->routeManager = new RouteManager(
            $this->mockRouteCollectionBuilder(),
            $this->mockRouteConfigFetcherGuzzle()
        );
    }

    /**
     * test load method.
     */
    public function testLoad()
    {
        $this->routeManager->load('http://false.json');

        $this->assertAttributeInstanceOf(
            'Symfony\Component\Routing\RouteCollection',
            'routeCollection',
            $this->routeManager
        );

        $this->assertAttributeInstanceOf(
            'Symfony\Component\Routing\Generator\UrlGenerator',
            'urlGenerator',
            $this->routeManager
        );
    }

    /**
     * test generateUrl method.
     */
    public function testGenerateUrl()
    {
        $this->routeManager->load('http://false.json');
        $response = $this->routeManager->generateUrl('my_route_get', array('id' => 42));

        $this->assertSame('http://localhost/my/route/get/42', $response);
    }

    /**
     * test generateUrl method when routeCollection not loaded.
     */
    public function testGenerateUrlFailureRouteCollectionNull()
    {
        $this->setExpectedException('Majora\RestClient\Exceptions\InvalidRouteCollectionException');
        $this->routeManager->generateUrl('my_route_get', array('id' => 42));
    }

    /**
     * test generateUrl method when routeCollection.
     */
    public function testGenerateUrlFailureParametersNotArray()
    {
        $this->routeManager->load('http://false.json');
        $this->setExpectedException('Majora\RestClient\Exceptions\InvalidRouteUrlParametersException');
        $this->routeManager->generateUrl('my_route_get', 42);
    }

    /**
     * test generateUrl method when route not exist.
     */
    public function testGenerateUrlFailureRouteNotExist()
    {
        $this->routeManager->load('http://false.json');
        $this->setExpectedException(
            'Symfony\Component\Routing\Exception\RouteNotFoundException',
            'Unable to generate a URL for the named route "my_route_false" as such route does not exist.'
        );

        $this->routeManager->generateUrl('my_route_false');
    }

    /**
     * test generateUrl method when parameters not exist.
     */
    public function testGenerateUrlFailureParametersNotExist()
    {
        $this->routeManager->load('http://false.json');
        $this->setExpectedException(
            'Symfony\Component\Routing\Exception\MissingMandatoryParametersException',
            'Some mandatory parameters are missing ("id") to generate a URL for route "my_route_get".'
        );

        $this->routeManager->generateUrl('my_route_get');
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
