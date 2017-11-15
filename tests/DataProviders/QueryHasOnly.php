<?php

namespace Arcesilas\ActiveState\Tests\DataProviders;

class QueryHasOnly
{

    public static function getData()
    {
        // [$requestUrl, $expected, array $params]
        return [
            ['foo/bar', true, []],
            ['foo/bar?arg1=val1', true, ['arg1']],
            ['foo/bar?arg2=val2&arg1=val1', true, ['arg1', 'arg2']],
            ['foo/bar?arg2=val2&arg1=val1', false, ['arg1']],
            ['foo/bar?arg2=val2', false, ['arg3', 'arg2']]
        ];
    }
}
