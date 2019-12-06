<?php

namespace Arcesilas\ActiveState\Tests\DataProviders;

class RouteIs
{
    public static function getSingleRouteData()
    {
        // [$requestUrl, $expected, $routeUri, $routeParameters]
        return [
            ['foo/bar', true, '/foo/bar', []],
            ['foo/bar', false, 'foo/bar/{slug}', []],
            ['foo/bar/42-title', true, 'foo/bar/{id}-{slug}', ['id' => 42, 'slug' => 'title']],
            ['foo/bar/title?s=baz', true, 'foo/bar/{slug}', ['slug' => 'title', 's' => 'baz']],
        ];
    }

    public static function getMultipleRoutesData()
    {
        // [$requestUrl, $expected, $routeUri, [
        //      $check
        // ]]
        return [
            // #0
            ['foo/bar', true, 'foo/bar', [
                'some.route' => [],
                'route.test' => []
            ]],
            // #1
            ['foo/bar/title', true, 'foo/bar/{slug}',[
                'some.route' => ['slug' => 'something'],
                'route.test' => ['slug' => 'title']
            ]],
            // #2
            ['foo/bar/title', false, 'foo/bar/{slug}', [
                'route.test' => ['slug' => 'something'],
                'route.test' => ['slug' => 'something-else']
            ]],
            // #3
            ['foo/bar/title', false, 'foo/bar/{slug}', [
                'some.route' => ['someArg' => 'someValue']
            ]]
        ];
    }
}
