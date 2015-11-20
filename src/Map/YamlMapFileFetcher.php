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
     * @param string $filePath
     */
    public function __construct($filePath = null)
    {
        $this->filePath = (null !== $filePath) ?
            $filePath :
            sprintf('%s%sRestClientMapping.yml', dirname(__DIR__), DIRECTORY_SEPARATOR);
    }

    /**
     * {@inheritdoc}
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
