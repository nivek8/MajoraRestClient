<?php

namespace Majora\RestClient\Map;

/**
 * Create and write a mapFile.
 * By default, path and name is define at generation
 */
class MapFileBuilder
{
    /**
     * Generate the mapfile
     * By default, the map file is generated at the root
     * You can add the filePath parameter to custom your mapfile
     *
     * @param null|string $file
     * @return bool
     */
    public function generate($file = null)
    {
        $file = ($file !== null) ? $file : sprintf('%s%sRestClientMapping.yml', dirname(__DIR__), DIRECTORY_SEPARATOR);

        if (file_exists($file)) {
            return false;
        }

        fopen($file, 'w+');

        return true;
    }
}
