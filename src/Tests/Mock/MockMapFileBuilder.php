<?php

namespace Majora\RestClient\Tests\Mock;

abstract class MockMapFileBuilder
{
    public static function initMapFile()
    {
        return array(
            'My\Namespace\Object\Path' => array(
                'GET' => array('my_object_get', 'my_object_cget'),
                'POST' => 'my_object_post',
                'PUT' => 'my_object_put',
                'DELETE' => 'my_object_delete',
            ),
        );
    }
}
