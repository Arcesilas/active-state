<?php

namespace Arcesilas\ActiveState;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ActiveStateServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        // Directive: @url_is(...$url)
        // Check current url is one of the given ones
        Blade::if(
            config('active.blade.url_is', 'url_is'),
            function (...$url) {
                return $this->app['active-state']->checkUrlIs(...$url);
            }
        );

        // Directive: @not_url_is(...$url)
        // Check current url is NOT one of the given ones
        Blade::if(
            config('active.blade.not_url_is', 'not_url_is'),
            function (...$url) {
                return ! $this->app['active-state']->checkUrlIs(...$url);
            }
        );

        // Directive: @url_has($url)
        // Check current url contains one of the given patterns
        Blade::if(
            config('active.blade.url_has', 'url_has'),
            function (...$url) {
                return $this->app['active-state']->checkUrlHas(...$url);
            }
        );

        // Directive: @url_has_not($url)
        Blade::if(
            config('active.blade.not_url_has', 'not_url_has'),
            function (...$url) {
                return ! $this->app['active-state']->checkUrlHas(...$url);
            }
        );

        // Directive: @route_is($route, $parameters)
        Blade::if(
            config('active.blade.route_is', 'route_is'),
            function ($route, $parameters) {
                return $this->app['active-state']->checkRouteIs($route, $parameters);
            }
        );

        // Directive: @not_route_is($route, $parameters)
        Blade::if(
            config('active.blade.not_route_is', 'not_route_is'),
            function ($route, $parameters) {
                return ! $this->app['active-state']->checkRouteIs($route, $parameters);
            }
        );

        // Directive: @route_in(...$routes)
        Blade::if(
            config('active.blade.route_in', 'route_in'),
            function (...$routes) {
                return $this->app['active-state']->checkRouteIn(...$routes);
            }
        );

        // Directive: @not_route_in(...$routes)
        Blade::if(
            config('active.blade.not_route_in', 'not_route_in'),
            function (...$routes) {
                return ! $this->app['active-state']->checkRouteIn(...$routes);
            }
        );

        // Directive: @query_is(...$parameters)
        Blade::if(
            config('active.blade.query_is', 'query_is'),
            function (...$parameters) {
                return $this->app['active-state']->checkQueryIs(...$parameters);
            }
        );

        // Directive: @not_query_is(...$parameters)
        Blade::if(
            config('active.blade.not_query_is', 'not_query_is'),
            function (...$parameters) {
                return ! $this->app['active-state']->checkQueryIs(...$parameters);
            }
        );

        // Directive: @query_has(...$parameters)
        Blade::if(
            config('active.blade.query_has', 'query_has'),
            function (...$parameters) {
                return $this->app['active-state']->checkQueryHas(...$parameters);
            }
        );

        // Directive: @not_query_has(...$parameterss)
        Blade::if(
            config('active.blade.not_query_has', 'not_query_has'),
            function (...$parameters) {
                return ! $this->app['active-state']->checkQueryHas(...$parameters);
            }
        );

        // Directive: @query_has_only
        Blade::if(
            config('active.blade.query_has_only', 'query_has_only'),
            function (...$parameters) {
                return $this->app['active-state']->checkQueryHasOnly(...$parameters);
            }
        );

        // Directive: @not_query_has_only
        Blade::if(
            config('active.blade.not_query_has_only', 'not_query_has_only'),
            function (...$parameters) {
                return ! $this->app['active-state']->checkQueryHasOnly(...$parameters);
            }
        );

        // Directive: @query_contains
        Blade::if(
            config('active.blade.query_contains', 'query_contains'),
            function ($parameters) {
                return $this->app['active-state']->checkQueryContains($parameters);
            }
        );

        // Directive: @not_query_contains
        Blade::if(
            config('active.blade.not_query_contains', 'not_query_contains'),
            function ($parameters) {
                return ! $this->app['active-state']->checkQueryContains($parameters);
            }
        );

        $this->publishes([
            __DIR__.'/config/active.php' => config_path('active.php'),
        ], 'config');
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->app->singleton('active-state', function ($app) {
            return new \Arcesilas\ActiveState\Active($app->make('request'));
        });

        $this->mergeConfigFrom(
            __DIR__.'/config/active.php',
            'active'
        );
    }
}
