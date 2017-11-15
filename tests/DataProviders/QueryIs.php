<?php

namespace Arcesilas\ActiveState\Tests\DataProviders;

class QueryIs
{
    public static function getData()
    {
        // [$requestUrl, $expected, array $params]
        return [
            // Parameters arrays have to be passed in array
            ['foo/bar', true, [
                // One empty parameter array
                []
            ]],
            ['foo/bar?arg1=val1&arg2=val2', true, [
                // One parameter array
                ['arg1' => 'val1', 'arg2' => 'val2']
            ]],
            ['foo/bar?arg1=val1&arg2=val2', false, [
                // One parameter array
                ['arg1' => 'val1']
            ]],
            ['foo/bar?arg1=val1', true,[
                ['arg1' => 'val1']
            ]],
            ['foo/bar?arg1=val1', false, [
                ['arg1' => 'val1', 'arg2' => 'val3']
            ]],
            ['foo/bar?arg1=val1', false, [
                // One parameter array
                ['arg1' => 'val2']
            ]],
            ['foo/bar?arg1=val1', false, [
                // One parameter array
                ['arg2' => 'val1']
            ]],
            ['foo/bar?arg1=val1', true, [
                // Multiple parameter arrays
                ['arg1' => 'val2'],
                ['arg1' => 'val1'] // This is the one that will match the query parameters
            ]],
            ['foo/bar?arg1=val1&arg2=val2', true, [
                // Multiple parameter arrays
                ['arg1' => 'val2'],
                ['arg1' => 'val1'],
                ['arg1' => 'val1', 'arg2' => 'val2'] // This is the one that will match the query parameters
            ]],
            // The order must not matter
            ['foo/bar?arg2=val2&arg1=val1', true, [
                ['arg1' => 'val1', 'arg2' => 'val2']
            ]]
        ];
    }
}
