<?php

namespace Majora\RestClient\Tests\Unit\Map;

use Majora\RestClient\Map\YamlMapFileFetcher;
use Majora\RestClient\Tests\Mock\MockMapFileBuilder;

class YamlMapFileFetcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MapFileFetcher
     */
    private $yamlMapFileFetcher;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $file = dirname(__DIR__).'/../Mock/MockMapFileBuilder.yml';
        $this->yamlMapFileFetcher = new YamlMapFileFetcher($file);
    }

    /**
     * test fetch method.
     */
    public function testFetch()
    {
        $namespace = 'My\Namespace\Object\Path';
        $response = $this->yamlMapFileFetcher->fetch($namespace);

        $this->assertSame(MockMapFileBuilder::initMapFile()[$namespace], $response);
    }

    /**
     * test fetch method failure where namespace not exist.
     */
    public function testFetchFailureNamespaceNotExist()
    {
        $namespace = 'My\Wrong\Nampesace';
        $this->setExpectedException('Exception');

        $this->yamlMapFileFetcher->fetch($namespace);
    }
}
