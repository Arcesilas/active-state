# ActiveState tools

## Helpers

Some helpers are available for all Active check methods:

* `active_url_is()`: `ifUrlIs`
* `active_url_has()`: `ifUrlHas`
* `active_route_is()`: `ifRouteIs`
* `active_route_in()`: `ifRouteIn`
* `active_query_is()`: `ifQueryIs`
* `active_query_has()`: `ifQueryHas`
* `active_query_has_only()`: `ifQueryHasOnly`
* `active_query_contains()`: `ifQueryContains`

They take the same arguments than the Active::if* methods and return their equivalent if* check result.

## Additional features

### Get state

`Active::getState($boolean)` allows you to get the active_value or inactive value for the boolean passed in argument.

### Get values

`Active::getActiveValue()` and `Active::getInactiveValue()` are available at any time to get the value for respectively Active and Inactive states.

### Reset values

You can reset Active and Inactive values to configuration defaults with `Active::resetValues()`
