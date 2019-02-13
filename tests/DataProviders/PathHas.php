<?php

namespace Arcesilas\ActiveState\Tests\DataProviders;

class PathHas
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
