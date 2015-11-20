<?php

namespace Majora\RestClient\Tests\Mock;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;

abstract class MockApiResponse
{
    const GET_RESPONSE = '{"id":1,"distId":"thisisjustastring","school":{"id":1,"name":"EPITA","studyLevel":5},"firstname":"doctor","lastname":"who","email":"doctorwho@gallifrey.fr","followedSchool":null,"mobility":"space and times"}';

    public static function mockGetResponse()
    {
        $handle = fopen('php://temp', 'w+');
        fwrite($handle, self::GET_RESPONSE);
        rewind($handle);

        $stream = new Stream($handle);
        $response = new Response('200', array(), $stream);

        return $response;
    }
}
