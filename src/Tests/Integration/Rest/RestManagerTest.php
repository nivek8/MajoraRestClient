<?php

namespace Majora\RestClient\Tests\Integration\Rest;

use GuzzleHttp\Client;
use Majora\RestClient\Map\MapFileManager;
use Majora\RestClient\Map\YamlMapFileFetcher;
use Majora\RestClient\Rest\GuzzleRestClient;
use Majora\RestClient\Rest\RestManager;
use Majora\RestClient\Route\RouteCollectionBuilder;
use Majora\RestClient\Route\RouteConfigFetcherGuzzle;
use Majora\RestClient\Route\RouteManager;
use Majora\RestClient\Tests\Mock\MockGuzzleClient;
use Majora\RestClient\Tests\Mock\MockApiResponse;

class RestManagerTest extends \PHPUnit_Framework_TestCase
{
    private $restManager;

    public function setUp()
    {
        // init routeManager
        $guzzleFetcherClient = $this->mockGuzzleClient();
        $guzzleFetcherClient->method('request')
            ->willReturn(MockGuzzleClient::initGuzzleRestResponse());

        $routeConigFetcherGuzzle = new RouteConfigFetcherGuzzle($guzzleFetcherClient);
        $routeManager = new RouteManager(new RouteCollectionBuilder(), $routeConigFetcherGuzzle);

        // init mapManager
        $mapManager = new MapFileManager(new YamlMapFileFetcher(dirname(dirname(__DIR__)).'/Mock/MockMapFileSirApi.yml'));

        // init restManager
        $guzzleRestClient = $this->mockGuzzleClient();
        $guzzleRestClient->method('request')
            ->willReturn(MockApiResponse::mockGetResponse());

        $this->restManager = new RestManager(
            $routeManager,
            $mapManager,
            new GuzzleRestClient($guzzleRestClient),
            'http://api.sir.dev/app_dev.php/js/routing.json'
        );
    }

    public function testGet() {
        $response = $this->restManager
            ->call('Majora\RestClient\Mock\Model\Sir\Partner')
            ->get(array('id' => 1));

        $this->assertSame($response, MockApiResponse::GET_RESPONSE);
    }

    private function mockGuzzleClient()
    {
        $mockGuzzleClient = $this->getMockBuilder('GuzzleHttp\Client')
            ->disableOriginalConstructor()
            ->getMock();

        return $mockGuzzleClient;
    }
}