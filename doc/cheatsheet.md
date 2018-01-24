# ActiveState cheatsheet

## Checks summary

| *Check* tests: `bool` | *If* tests: `string` | Arguments                             | Description                                            |
|-----------------------|----------------------|---------------------------------------|--------------------------------------------------------|
| checkUrlIs            | ifUrlIs              | `...$patterns`                        | Check the URL is exactly the given value(s)            |
| checkUrlHas           | ifUrlHas             | `...$patterns`                        | Check the URL contains one or more strings             |
| checkRouteIs          | ifRouteIs            | `$route, array $routeParameters = []` | Check the current route name and the parameters values |
| checkRouteIn          | ifRouteIn            | `...$routes`                          | Check current route name                               |
| checkQueryIn          | ifQueryIn            | `array ...$parameters`                | Check query parameters are exactly the ones given      |
| checkQueryHas         | ifQueryHas           | `...$parameters`                      | Check parameters are present in the query string       |
| checkQueryHasOnly     | ifQueryHasOnly       | `...$parameters`                      | Check query string has only the given parameters       |
| checkQueryContains    | ifQueryContains      | `$parameters`                         | Check query parameters are contained in the query      |

## Blade directives

Blade directives take the same arguments as their `Active::check*` equivalent.

| Blade directive | Active::check* equivalent | Opposite directive  |
|-----------------|---------------------------|---------------------|
| @url_is         | checkUrlIs                | @not_url_is         |
| @url_has        | checkUrlHas               | @not_url_has        |
| @route_is       | checkRouteIs              | @not_route_is       |
| @route_in       | checkRouteIn              | @not_route_in       |
| @route_has      | checkRouteHas             | @not_route_has      |
| @query_is       | checkQueryIs              | @not_query_is       |
| @query_has      | checkQueryHas             | @not_query_has      |
| @query_has_only | checkQueryHasOnly         | @not_query_has_only |
| @query_contains | checkQueryContains        | @not_query_contains |

## Helpers

Helpers take the same arguments as their `Active::if*` equivalent.

| Helper                | Active::if* equivalent |
|-----------------------|------------------------|
| active_url_is         | ifUrlIs                |
| active_url_has        | ifUrlHas               |
| active_route_is       | ifRouteIs              |
| active_route_in       | ifRouteIn              |
| active_query_is       | ifQueryIs              |
| active_query_has      | ifQueryHas             |
| active_query_has_only | ifQueryHasOnly         |
| active_query_contains | ifQueryContains        |

## Misc

Get the state value for a state boolean:
```php
Active::getState($boolean);
```

Get the active and inactive values:
```php
Active::getActiveValue;
Active::getInactiveValue;
```

## Configuration at runtime

* `Active::setActiveValue($value, $persistent = null)`
* `Active::setInactiveValue($value, $persistent = null)`

Reset value to their configuration default:
`Active::resetValues;`

## Configuration file

Summary of the default values:

```php
return [
    'active_state'      =>  'active',
    'inactive_state'    =>  '',
    'blade' => [
        'url_is'             => 'url_is',
        'not_url_is'         => 'not_url_is',
        'url_has'            => 'url_has',
        'not_url_has'        => 'not_url_has',
        'route_is'           => 'route_is',
        'not_route_is'       => 'not_route_is',
        'route_in'           => 'route_in',
        'not_route_in'       => 'not_route_in',
        'query_is'           => 'query_is',
        'not_query_is'       => 'not_query_is',
        'query_has'          => 'query_has',
        'not_query_has'      => 'not_query_has',
        'query_has_only'     => 'query_has_only',
        'not_query_has_only' => 'not_query_has_only',
        'query_contains'     => 'query_contains',
        'not_query_contains' => 'not_query_contains'
    ]
];
```
