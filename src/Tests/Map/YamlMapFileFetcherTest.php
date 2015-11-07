<?php

namespace Majora\RestClient\Tests\Map;

use Majora\RestClient\Map\YamlMapFileFetcher;
use Majora\RestClient\Tests\Mock\MockMapFileBuilder;

class YamlMapFileFetcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MapFileFetcher
     */
    private $yamlMapFileFetcher;

    /**
     * @inheritDocx
     */
    public function setUp()
    {
        $file = __DIR__.'/../Mock/MockMapFileBuilder.yml';
        $this->yamlMapFileFetcher = new YamlMapFileFetcher($file);
    }

    /**
     * test fetch method
     */
    public function testFetch()
    {
        $namespace = 'My\Namespace\Object\Path';
        $response = $this->yamlMapFileFetcher->fetch($namespace);

        $this->assertSame(MockMapFileBuilder::initMapFile()[$namespace], $response);
    }

    public function testFetchFailureNamespaceNotExist()
    {
        $namespace = 'My\Wrong\Nampesace';
        $this->setExpectedException('Exception');

        $this->yamlMapFileFetcher->fetch($namespace);
    }
}