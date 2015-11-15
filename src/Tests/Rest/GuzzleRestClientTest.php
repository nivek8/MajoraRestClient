<?php

namespace Majora\RestClient\Tests\Rest;

use Majora\RestClient\Rest\GuzzleRestClient;
use Majora\RestClient\Tests\Mock\MockGuzzleClient;

class GuzzleRestClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GuzzleRestClient
     */
    private $guzzleRestClient;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->guzzleRestClient = new GuzzleRestClient(
            $this->mockGuzzleRestClient()
        );
    }

    /**
     * test request method.
     */
    public function testRequest()
    {
        $response = $this->guzzleRestClient->request('GET', 'http://www.false.url');
        $this->assertJson($response);
    }

    /**
     * test asyncRequest method.
     */
    public function testAsyncRequest()
    {
        $response = $this->guzzleRestClient->asyncRequest('GET', 'http://www.false.url');
        $this->assertJson($response);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function mockGuzzleRestClient()
    {
        $mockGuzzleRestClient = $this->getMockBuilder('GuzzleHttp\ClientInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $mockGuzzleRestClient->method('request')
            ->willReturn(MockGuzzleClient::initGuzzleRestResponse());

        $mockGuzzleRestClient->method('requestAsync')
            ->willReturn(MockGuzzleClient::initGuzzleRestResponse());

        return $mockGuzzleRestClient;
    }
}
