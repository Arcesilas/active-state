<?php

namespace Arcesilas\ActiveState\Tests\DataProviders;

class UrlHas
{
    public static function getData()
    {
        // [$expected, $testUrl]
        return [
            [true, ['/']],
            [true, ['foo/bar']],
            [true, ['foo']],
            [true, ['bar']],
            [true, ['baz', 'bar']],
            [false, ['baz']],
        ];
    }
}
