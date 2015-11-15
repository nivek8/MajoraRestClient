<?php

namespace Majora\RestClient\Map;

class MapFileBuilder
{
    /**
     * create RestClientMapping.
     */
    public function generate()
    {
        $file = sprintf('%s%sRestClientMapping.yml', dirname(__DIR__), DIRECTORY_SEPARATOR);

        if (file_exists($file)) {
            return false;
        }

        fopen($file, 'w+');

        return true;
    }
}
