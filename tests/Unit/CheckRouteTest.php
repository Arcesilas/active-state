<?php

namespace Arcesilas\ActiveState\Tests\Unit;

use Illuminate\Routing\Router;
use PHPUnit\Framework\TestCase;
use Arcesilas\ActiveState\Active;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Routing\RoutingServiceProvider;

class CheckRouteTest extends TestCase
{

    protected $routeName = 'route.test';

    protected function init($requestUrl, $routeUri, $routeName = null, $dispatch = false)
    {
        $routeName = $routeName ?? $this->routeName;

        // Make a Laravel application
        $app = new Application(__DIR__);

        // Register a request
        $request = HttpRequest::create('http://example.com/'.$requestUrl);
        $app->instance('request', $request);

        // Register routing service
        $app->register(RoutingServiceProvider::class);

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

        // Return an Active instance
        return new Active($request);
    }

    /**
     * @dataProvider Arcesilas\ActiveState\Tests\DataProviders\RouteIs::getSingleRouteData()
     */
    public function testSingleIfRoute($requestUrl, $expected, $routeUri, $routeParameters)
    {
        $active = $this->init($requestUrl, $routeUri);

        $this->assertSame($expected, $active->checkRouteIs($this->routeName, $routeParameters));
    }

    /**
     * @dataProvider Arcesilas\ActiveState\Tests\DataProviders\RouteIs::getMultipleRoutesData()
     */
    public function testMultiplelIfRoute($requestUrl, $expected, $routeUri, $check)
    {
        $active = $this->init($requestUrl, $routeUri);

        $this->assertSame($expected, $active->checkRouteIs($check));
    }

    /**
     * @dataProvider Arcesilas\ActiveState\Tests\DataProviders\RouteIn::getData()
     */
    public function testIfRouteIn($routeName, $expected, $routes)
    {
        // Here, we need to dispatch, for the route to be resolved by the request
        $active = $this->init('foo/bar', 'foo/bar', $routeName, true);

        $this->assertSame($expected, $active->checkRouteIn(...$routes));
    }

    /**
     * @dataProvider Arcesilas\ActiveState\Tests\DataProviders\RouteIs::getSingleRouteData()
     */
    public function testSingleIfNotRoute($requestUrl, $expected, $routeUri, $routeParameters)
    {
        $active = $this->init($requestUrl, $routeUri);

        $this->assertSame(! $expected, $active->checkNotRouteIs($this->routeName, $routeParameters));
    }

    /**
     * @dataProvider Arcesilas\ActiveState\Tests\DataProviders\RouteIs::getMultipleRoutesData()
     */
    public function testMultiplelIfNotRoute($requestUrl, $expected, $routeUri, $check)
    {
        $active = $this->init($requestUrl, $routeUri);

        $this->assertSame(! $expected, $active->checkNotRouteIs($check));
    }

    /**
     * @dataProvider Arcesilas\ActiveState\Tests\DataProviders\RouteIn::getData()
     */
    public function testIfNotRouteIn($routeName, $expected, $routes)
    {
        // Here, we need to dispatch, for the route to be resolved by the request
        $active = $this->init('foo/bar', 'foo/bar', $routeName, true);

        $this->assertSame(! $expected, $active->checkNotRouteIn(...$routes));
    }
}
