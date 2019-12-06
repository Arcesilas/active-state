<?php

declare(strict_types=1);

namespace Arcesilas\ActiveState\Tests\Unit\Active;

use Arcesilas\ActiveState\Tests\TestCase;
use Arcesilas\ActiveState\Active;
use Illuminate\Http\Request as HttpRequest;

/** @coversDefaultClass Arcesilas\ActiveState\Active */
class CheckRouteTest extends TestCase
{
    protected $active;

    protected $defaultRouteName = 'route.test';

    protected function init($requestUrl, $routeUri, $routeName = null, $dispatch = false)
    {
        $app = app();
        $routeName = $routeName ?? $this->defaultRouteName;

        // Register a request
        $request = HttpRequest::create('http://example.com/'.$requestUrl);
        $app->instance('request', $request);

        // Define a route
        $router = $app->make('router');
        $router->get($routeUri, function () {
            //
        })->name($routeName);

        // Refresh name list
        $router->getRoutes()->refreshNameLookups();
        if ($dispatch) {
            $router->dispatch($request);
        }

        $this->active = new Active($request);
    }

    /**
     * @dataProvider SingleRouteIsProvider
     * @covers ::checkRouteIs
     */
    public function testSingleIfRoute($requestUrl, $expected, $routeUri, $routeParameters)
    {
        $this->init($requestUrl, $routeUri);

        $this->assertSame($expected, $this->active->checkRouteIs($this->defaultRouteName, $routeParameters));
    }

    /**
     * @dataProvider MultipleRouteIsProvider
     * @covers ::checkRouteIs
     */
    public function testMultiplelIfRoute($requestUrl, $expected, $routeUri, $check)
    {
        $this->init($requestUrl, $routeUri);

        $this->assertSame($expected, $this->active->checkRouteIs($check));
    }

    /**
     * @dataProvider routeInProvider
     * @covers ::checkRouteIn
     */
    public function testIfRouteIn($routeName, $expected, $routes)
    {
        // Here, we need to dispatch, for the route to be resolved by the request
        $this->init('foo/bar', 'foo/bar', $routeName, true);

        $this->assertSame($expected, $this->active->checkRouteIn(...$routes));
    }

    /**
     * @dataProvider singleRouteIsProvider
     * @covers ::__call
     * @covers ::checkRouteIs
     */
    public function testSingleIfNotRoute($requestUrl, $expected, $routeUri, $routeParameters)
    {
        $this->init($requestUrl, $routeUri);

        $this->assertSame(! $expected, $this->active->checkNotRouteIs($this->defaultRouteName, $routeParameters));
    }

    /**
     * @dataProvider multipleRouteIsProvider
     * @covers ::__call
     * @covers ::checkRouteIs
     */
    public function testMultiplelIfNotRoute($requestUrl, $expected, $routeUri, $check)
    {
        $this->init($requestUrl, $routeUri);

        $this->assertSame(! $expected, $this->active->checkNotRouteIs($check));
    }

    /**
     * @dataProvider routeInProvider
     * @covers ::__call
     * @covers ::checkRouteIn
     */
    public function testIfNotRouteIn($routeName, $expected, $routes)
    {
        // Here, we need to dispatch, for the route to be resolved by the request
        $this->init('foo/bar', 'foo/bar', $routeName, true);

        $this->assertSame(! $expected, $this->active->checkNotRouteIn(...$routes));
    }

    public function singleRouteIsProvider()
    {
        // [$requestUrl, $expected, $routeUri, $routeParameters]
        return [
            ['foo/bar', true, '/foo/bar', []],
            ['foo/bar', false, 'foo/bar/{slug}', []],
            ['foo/bar/42-title', true, 'foo/bar/{id}-{slug}', ['id' => 42, 'slug' => 'title']],
            ['foo/bar/title?s=baz', true, 'foo/bar/{slug}', ['slug' => 'title', 's' => 'baz']],
        ];
    }

    public function multipleRouteIsProvider()
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

    public function routeInProvider()
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
