<?php

return [
    // The default  value if the request match given action
    'active_state'      =>  'active',

    // The default  value if the request match given action
    'inactive_state'    =>  '',

    // Blade directives
    // Warning: if you change these values, you'll need to update your views!
    'blade' => [
        // checkUrlIs()
        'url_is'           => 'url_is',

        // ! checkUrlIs()
        'not_url_is'       => 'not_url_is',

        // checkUrlHas()
        'url_has'       => 'url_has',

        // ! checkUrlHas()
        'not_url_has'   => 'not_url_has',

        // checkRouteIs()
        'route_is'         => 'route_is',

        // ! checkRouteIs()
        'not_route_is'     => 'not_route_is',

        // checkRouteIn()
        'route_in'      => 'route_in',

        // ! checkRouteIn()
        'not_route_in'  => 'not_route_in',

        // checkQueryIs()
        'query_is'         => 'query_is',

        // ! checkQueryIs()
        'not_query_is'     => 'not_query_is',

        // checkQueryHas()
        'query_has'     => 'query_has',

        // ! checkQueryHas()
        'not_query_has' => 'not_query_has',

        // checkQueryHasOnly()
        'query_has_only' => 'query_has_only',

        // ! checkQueryHasOnly
        'not_query_has_only' => 'not_query_has_only',

        // checkQueryContains()
        'query_contains' => 'query_contains',

        // ! checkQueryContains()
        'not_query_contains' => 'not_query_contains'
    ]
];
