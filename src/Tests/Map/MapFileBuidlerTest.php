<?php

namespace Majora\RestClient\Tests\Map;

use Majora\RestClient\Map\MapFileBuilder;

class MapFileBuidlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MapFileBuilder
     */
    private $mapFileBuilder;

    /**
     * @var string
     */
    private $filePath;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->mapFileBuilder = new MapFileBuilder();
        $this->filePath = sprintf('%s%sRestClientMapping.yml', dirname(dirname(__DIR__)), DIRECTORY_SEPARATOR);
    }

    public function tearDown()
    {
        unlink($this->filePath);
    }

    /**
     * test generate method.
     */
    public function testGenerate()
    {
        $response = $this->mapFileBuilder->generate();

        $this->assertTrue(file_exists($this->filePath));
        $this->assertTrue($response);
    }

    /**
     * test generate method when file exist.
     */
    public function testGenerateWhenFileExist()
    {
        fopen($this->filePath, 'w+');
        $response = $this->mapFileBuilder->generate();

        $this->assertTrue(file_exists($this->filePath));
        $this->assertFalse($response);
    }
}
