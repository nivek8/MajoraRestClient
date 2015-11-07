<?php

namespace Majora\RestClient\Tests\Map;

use Majora\RestClient\Map\MapFileManager;
use Majora\RestClient\Map\YamlMapFileFetcher;
use Majora\RestClient\Tests\Mock\MockMapFileBuilder;

class MapFileManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MapFileManager
     */
    private $mapFileManager;

    /**
     * @inheritDoc
     */
    public function setUp()
    {
        $this->mapFileManager = new MapFileManager(
        $this->mockMapFileFetcher()
        );
    }

    /**
     * test load method
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
     * test getMap
     */
    public function testGetMapObjectBeforeLoad()
    {
        $this->assertNull($this->mapFileManager->getMap());
    }

    public function testGetMapObjectAfterLoad()
    {
        $this->mapFileManager->load('My\Namespace\Object\Path');

        $this->assertSame(
            MockMapFileBuilder::initMapFile()['My\Namespace\Object\Path'],
            $this->mapFileManager->getMap()
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