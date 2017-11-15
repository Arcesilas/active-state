<?php

namespace Arcesilas\ActiveState\Tests\Feature\BladeDirectivesTests;

use Active;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Routing\RoutingServiceProvider;

class RouteTest extends BladeDirectivesTestCase
{
    public function setUp()
    {
        $this->app = new Application(__DIR__);

        $this->initBlade();
        $this->loadActiveStateServiceProvider();

        $this->app->register(RoutingServiceProvider::class);

        $router = $this->app->make('router');
    }

    public function init($requestUrl, $routeUri, $routeName = 'route.test', $dispatch = false)
    {
        $this->app['request'] = HttpRequest::create('http://example.com/'.$requestUrl);

        // Define a route
        $this->app['router']->get($routeUri, function () {
            //
        })->name($routeName);

        $this->app['router']->getRoutes()->refreshNameLookups();
        if ($dispatch) {
            $this->app['router']->dispatch($this->app['request']);
        }
    }

    public function singleRouteIsProvider()
    {
        // [$requestUrl, $expected, $routeUri, $routeParameters]
        return [
            ['foo/bar', true, 'foo/bar', []],
            ['foo/bar', false, 'foo/bar/{slug}', []],
            ['foo/bar/42-title', true, 'foo/bar/{id}-{slug}', ['id' => 42, 'slug' => 'title']],
            ['foo/bar/title?s=baz', true, 'foo/bar/{slug}', ['slug' => 'title', 's' => 'baz']],
        ];
    }

    /**
     * @dataProvider singleRouteIsProvider
     */
    public function testSingleRouteIs($requestUrl, $expected, $routeUri, $routeParameters)
    {
        $this->init($requestUrl, $routeUri);

        $this->assertEquals(
            $this->expected($expected),
            view('route_is', ['route' => 'route.test', 'parameters' => $routeParameters])->render()
        );
    }

    /**
     * @dataProvider singleRouteIsProvider
     */
    public function testSingleNotRouteIs($requestUrl, $expected, $routeUri, $routeParameters)
    {
        $this->init($requestUrl, $routeUri);
        $this->assertEquals(
            $this->expected(! $expected),
            view('not_route_is', ['route' => 'route.test', 'parameters' => $routeParameters])->render()
        );
    }

    public function multipleRouteIsProvider()
    {
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

    /**
     * @dataProvider multipleRouteIsProvider
     */
    public function testMultipleRouteIs($requestUrl, $expected, $routeUri, $check)
    {
        $this->init($requestUrl, $routeUri);
        $this->assertEquals(
            $this->expected($expected),
            view('route_is', ['route' => $check, 'parameters' => []])->render()
        );
    }

    /**
     * @dataProvider multipleRouteIsProvider
     */
    public function testMultipleNotRouteIs($requestUrl, $expected, $routeUri, $check)
    {
        $this->init($requestUrl, $routeUri);
        $this->assertEquals(
            $this->expected(! $expected),
            view('not_route_is', ['route' => $check, 'parameters' => []])->render()
        );
    }

    // [$routeName, $expected, $routes]
    public function routeInProvider()
    {
        return [
            ['some.route', true, ['some.route']],
            ['some.route', false, ['incorrectRoute']],
            ['some.route', true, ['incorrectRoute', 'some.route', 'another.one']],
            ['some.route', false, ['incorrectRoute', 'another.incorrectRoute']]
        ];
    }

    /**
     * @dataProvider routeInProvider
     */
    public function testRouteIn($routeName, $expected, $routes)
    {
        $this->init('foo/bar', 'foo/bar', $routeName, true);
        $this->assertEquals(
            $this->expected($expected),
            view('route_in', ['routes' => $routes])->render()
        );
    }

    /**
     * @dataProvider routeInProvider
     */
    public function testNotRouteIn($routeName, $expected, $routes)
    {
        $this->init('foo/bar', 'foo/bar', $routeName, true);
        $this->assertEquals(
            $this->expected(! $expected),
            view('not_route_in', ['routes' => $routes])->render()
        );
    }
}
