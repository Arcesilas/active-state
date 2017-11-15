<?php

if (! function_exists('active_url_is')) {
    /**
     * @see Arcesilas\ActiveState\Active::ifUrlIs()
     * @param $urls  Url to check
     * @return string
     */
    function active_url_is(...$urls)
    {
        return app('active-state')->ifUrlIs(...$urls);
    }
}

if (! function_exists('active_url_has')) {
     /**
      * @see Arcesilas\ActiveState\Active::ifUrlHas()
      * @param  string  $urls
      * @return string
      */
    function active_url_has(...$urls)
    {
        return app('active-state')->ifUrlHas(...$urls);
    }
}

if (! function_exists('active_route_is')) {
    /**
     * @see Arcesilas\ActiveState\Active::ifRouteIs()
     * @param string $route  The route name
     * @param array $parameters The route parameters used to build the url
     * @return string
     */
    function active_route_is($route, $parameters = [])
    {
        return app('active-state')->ifRouteIs($route, $parameters);
    }
}

if (! function_exists('active_route_in')) {
    /**
     * @see Arcesilas\ActiveState\Active::ifRouteIn()
     * @param  string  $urls
     * @return string
     */
    function active_route_in(...$routes)
    {
        return app('active-state')->ifRouteIn(...$routes);
    }
}

if (! function_exists('active_query_is')) {
    /**
     * @see Arcesilas\ActiveState\Active::ifQueryIs()
     * @param array $parameters  The parameters to check iin the query string
     * @return string
     */
    function active_query_is(array ...$parameters)
    {
        return app('active-state')->ifQueryIs(...$parameters);
    }
}

if (! function_exists('active_query_has')) {
    /**
     * @see Arcesilas\ActiveState\Active::ifQueryHas()
     * @param array $parameters  The parameters to check iin the query string
     * @return string
     */
    function active_query_has(...$parameters)
    {
        return app('active-state')->ifQueryHas(...$parameters);
    }
}

if (! function_exists('active_query_has_only')) {
    /**
     * @see Arcesilas\ActiveState\Active::ifQueryHasOnly()
     * @param  string  $parameters
     * @return string
     */
    function active_query_has_only(...$parameters)
    {
        return app('active-state')->ifQueryHasOnly(...$parameters);
    }
}

if (! function_exists('active_query_contains')) {
    /**
     * @see Arcesilas\ActiveState\Active::ifQueryContains()
     * @param  string  $parameters
     * @return string
     */
    function active_query_contains($parameters)
    {
        return app('active-state')->ifQueryContains($parameters);
    }
}
