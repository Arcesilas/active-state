<?php

namespace Arcesilas\ActiveState\Tests\DataProviders;

class QueryContains
{
    // [$requestUrl, $expected, $params]
    public static function getData()
    {
        return [
            ['foo/bar', true, []],
            ['foo/bar?arg1=val1&arg3=val3&arg2=val2', true, [
                'arg3' => 'val3', 'arg1' => 'val1'
            ]],
            ['foo/bar?arg1=val1&arg3=val3', false, [
                'arg1' => 'val1', 'arg2' => 'val2'
            ]],
            ['foo/bar?arg1=val1', false, [
                'arg1' => 'val2'
            ]]
        ];
    }
}
