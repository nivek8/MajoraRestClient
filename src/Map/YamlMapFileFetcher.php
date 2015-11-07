<?php

namespace Majora\RestClient\Map;

use Symfony\Component\Yaml\Yaml;

class YamlMapFileFetcher implements MapFileFetcherInterface
{
    /**
     * @var string
     */
    private $filePath;

    /**
     * @param MapFileBuilder $mapFileBuilder
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @inheritDoc
     */
    public function fetch($namespace)
    {
        $schema = yaml::parse(file_get_contents($this->filePath));

        if (!array_key_exists($namespace, $schema)) {
            throw new \Exception('the route attach anything class. Please configure your route Mapping');
        }

        return $schema[$namespace];
    }
}