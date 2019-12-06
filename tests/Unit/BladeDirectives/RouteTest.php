<?php

declare(strict_types=1);

namespace Arcesilas\ActiveState\Tests\Unit\BladeDirectives;

use Arcesilas\ActiveState\Tests\TestCase;
use Illuminate\Http\Request as HttpRequest;

class RouteTest extends BladeDirectivesTestCase
{
    protected function init($requestUrl, $routeUri, $routeName = 'route.test', $dispatch = false)
    {
        $this->app['request'] = HttpRequest::create('http://example.com/'.$requestUrl);

        // Define a route
        $this->app['router']->get($routeUri, function () {})->name($routeName);

        if ($dispatch) {
            $this->app['router']->dispatch($this->app['request']);
        }
    }

    /** @dataProvider Arcesilas\ActiveState\Tests\Unit\Active\CheckRouteTest::singleRouteIsProvider */
    public function testSingleRouteIs($requestUrl, $expected, $routeUri, $routeParameters)
    {
        $this->init($requestUrl, $routeUri,);
        $this->assertSame(
            $this->expected($expected),
            view('route_is', ['route' => 'route.test', 'parameters' => $routeParameters])->render()
        );
    }

    /** @dataProvider Arcesilas\ActiveState\Tests\Unit\Active\CheckRouteTest::singleRouteIsProvider */
    public function testSingleNotRouteIs($requestUrl, $expected, $routeUri, $routeParameters)
    {
        $this->init($requestUrl, $routeUri);
        $this->assertSame(
            $this->expected(! $expected),
            view('not_route_is', ['route' => 'route.test', 'parameters' => $routeParameters])->render()
        );
    }

    /** @dataProvider Arcesilas\ActiveState\Tests\Unit\Active\CheckRouteTest::multipleRouteIsProvider */
    public function testMultipleRouteIs($requestUrl, $expected, $routeUri, $check)
    {
        $this->init($requestUrl, $routeUri);
        $this->assertEquals(
            $this->expected($expected),
            view('route_is', ['route' => $check, 'parameters' => []])->render()
        );
    }

     /** @dataProvider Arcesilas\ActiveState\Tests\Unit\Active\CheckRouteTest::multipleRouteIsProvider */
    public function testMultipleNotRouteIs($requestUrl, $expected, $routeUri, $check)
    {
        $this->init($requestUrl, $routeUri);
        $this->assertEquals(
            $this->expected(! $expected),
            view('not_route_is', ['route' => $check, 'parameters' => []])->render()
        );
    }

    /** @dataProvider Arcesilas\ActiveState\Tests\Unit\Active\CheckRouteTest::routeInProvider */
    public function testRouteIn($routeName, $expected, $routes)
    {
        $this->init('foo/bar', 'foo/bar', $routeName, true);
        $this->assertEquals(
            $this->expected($expected),
            view('route_in', ['routes' => $routes])->render()
        );
    }

    /** @dataProvider Arcesilas\ActiveState\Tests\Unit\Active\CheckRouteTest::routeInProvider */
    public function testNotRouteIn($routeName, $expected, $routes)
    {
        $this->init('foo/bar', 'foo/bar', $routeName, true);
        $this->assertEquals(
            $this->expected(! $expected),
            view('not_route_in', ['routes' => $routes])->render()
        );
    }
}
