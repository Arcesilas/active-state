<?php

namespace Arcesilas\ActiveState\Tests\DataProviders;

class QueryHas
{
    public static function getData()
    {
        // [$requestUrl, $expected, array $params]
        return [
            ['foo/bar?arg1=val1&arg2=val2', true, ['arg1']],
            ['foo/bar?arg1=val1&arg2=val2', true, ['arg1', 'arg2']],
            ['foo/bar?arg1=val1&arg2=val2', true, ['arg2', 'arg1']],
            ['foo/bar?arg1=val1&arg2=val2', false, ['arg3']],
            ['foo/bar?arg1=val1&arg2=val2', false, ['arg1', 'arg3']],
            ['foo/bar', false, ['arg1']],
            ['foo/bar?', false, ['arg1']],
            ['foo/bar', true, []],
            ['foo/bar?', true, []]
        ];
    }
}
