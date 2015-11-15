<?php

namespace Majora\RestClient\Map;

interface MapFileFetcherInterface
{
    /**
     * @param $namespace
     *
     * @return mixed
     */
    public function fetch($namespace);
}
