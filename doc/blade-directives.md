# ActiveState Blade directives

The following _if_ Blade directives are defined by default for their equivalent checks:

* `@path_is()`: `checkPathIs()`
* `@path_has()`: `checkPathHas()`
* `@route_is()`: `checkRouteIs()`
* `@route_in()`: `checkRouteIn()`
* `@route_has()`: `checkRouteHas()`
* `@query_is()`: `checkQueryIs()`
* `@query_has()`: `checkQueryHas()`
* `@query_has_only()`: `checkHasOnly()`
* `@query_contains()`: `checkQueryContains()`

All these directives have their opposites. Just prepend "not_" to the directive.

Examples of use:

If/else check:
```blade
@route_is('user.show')
    // The route is user.show
@elseroute_is
    // The route is not user.show
@endroute_is
```

Negative check:
```blade
@not_route_is('user.show')
    // The route is NOT user.show
@endnot_route_is
```

The directives simply replace Active::check* calls, which can obviously be used instead, if you prefer.

> **Note**: If you change the Blade directives configuration, you need to clear the compiled views:
> ``` shell
> php artisan view:clear
> ```
