<?php

namespace Arcesilas\ActiveState\Tests\DataProviders;

class RouteIn
{
    public static function getData()
    {
        // [$routeName, $expected, $routes]
        return [
            ['some.route', true, ['some.route']],
            ['some.route', false, ['incorrectRoute']],
            ['some.route', true, ['incorrectRoute', 'some.route', 'another.one']],
            ['some.route', false, ['incorrectRoute', 'another.incorrectRoute']]
        ];
    }
}
