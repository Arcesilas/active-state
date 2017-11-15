<?php

namespace Arcesilas\ActiveState\Tests\DataProviders;

class UrlIs
{
    public static function getData()
    {
        // [$expected, $testUrl]
        return [
            [true, 'foo/bar'],
            [false, 'foo/baz'],
            [false, 'foo'],
            [true, 'fo*']
        ];
    }
}
