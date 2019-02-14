<?php

/** @codeCoverageIgnoreStart */

if (! function_exists('active_url_is')) {
    /**
     * Alias os active_path_is for backward compatibility
     * @see active_path_is
     */
    function active_url_is(...$urls)
    {
        return active_path_is(...$urls);
    }
}

if (! function_exists('active_url_has')) {
    /**
    * Alias os active_path_has for backward compatibility
    * @see active_path_has
    */
    function active_url_has(...$paths)
    {
        return active_path_has(...$paths);
    }
}

/**@codeCoverageIgnoreEnd */

if (! function_exists('active_path_is')) {
    /**
     * @see Arcesilas\ActiveState\Active::ifPathIs()
     * @param $paths  Paths to check
     * @return string
     */
    function active_path_is(...$paths)
    {
        return app('active-state')->ifPathIs(...$paths);
    }
}

if (! function_exists('active_not_path_is')) {
    /**
     * @see Arcesilas\ActiveState\Active::ifNotPathIs()
     * @param $paths  Paths to check
     * @return string
     */
    function active_not_path_is(...$paths) {
        return app('active-state')->ifNotPathIs(...$paths);
    }
}

if (! function_exists('active_path_has')) {
     /**
      * @see Arcesilas\ActiveState\Active::ifPathHas()
      * @param  string[]  $paths  Paths to check
      * @return string
      */
    function active_path_has(...$paths)
    {
        return app('active-state')->ifPathHas(...$paths);
    }
}

if (! function_exists('active_not_path_has')) {
    /**
     * @see Arcesilas\ActiveState\Active::ifNotPathHas()
     * @param  string[]  $paths  Paths to check
     * @return string
     */
    function active_not_path_has(...$paths)
    {
        return app('active-state')->ifNotPathHas(...$paths);
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

if (! function_exists('active_not_route_is')) {
    /**
     * @see Arcesilas\ActiveState\Active::ifNotRouteIs()
     * @param string $route  The route name
     * @param array $parameters The route parameters used to build the url
     * @return string
     */
    function active_not_route_is($route, $parameters = [])
    {
        return app('active-state')->ifNotRouteIs($route, $parameters);
    }
}

if (! function_exists('active_route_in')) {
    /**
     * @see Arcesilas\ActiveState\Active::ifRouteIn()
     * @return string
     */
    function active_route_in(...$routes)
    {
        return app('active-state')->ifRouteIn(...$routes);
    }
}

if (! function_exists('active_not_route_in')) {
    /**
     * @see Arcesilas\ActiveState\Active::ifNotRouteIn()
     * @return string
     */
    function active_not_route_in(...$routes)
    {
        return app('active-state')->ifNotRouteIn(...$routes);
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

if (! function_exists('active_not_query_is')) {
    /**
     * @see Arcesilas\ActiveState\Active::ifNotQueryIs()
     * @param array $parameters  The parameters to check iin the query string
     * @return string
     */
    function active_not_query_is(array ...$parameters)
    {
        return app('active-state')->ifNotQueryIs(...$parameters);
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

if (! function_exists('active_not_query_has')) {
    /**
     * @see Arcesilas\ActiveState\Active::ifNotQueryHas()
     * @param array $parameters  The parameters to check iin the query string
     * @return string
     */
    function active_not_query_has(...$parameters)
    {
        return app('active-state')->ifNotQueryHas(...$parameters);
    }
}

if (! function_exists('active_query_has_only')) {
    /**
     * @see Arcesilas\ActiveState\Active::ifQueryHasOnly()
     * @param  string[]  $parameters
     * @return string
     */
    function active_query_has_only(...$parameters)
    {
        return app('active-state')->ifQueryHasOnly(...$parameters);
    }
}

if (! function_exists('active_not_query_has_only')) {
    /**
     * @see Arcesilas\ActiveState\Active::ifNotQueryHasOnly()
     * @param  string[]  $parameters
     * @return string
     */
    function active_not_query_has_only(...$parameters)
    {
        return app('active-state')->ifNotQueryHasOnly(...$parameters);
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

if (! function_exists('active_not_query_contains')) {
    /**
     * @see Arcesilas\ActiveState\Active::ifNotQueryContains()
     * @param  string  $parameters
     * @return string
     */
    function active_not_query_contains($parameters)
    {
        return app('active-state')->ifNotQueryContains($parameters);
    }
}
