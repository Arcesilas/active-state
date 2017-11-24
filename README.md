# Active State

> Laravel link active state helper based on URL, route or query string

Sometimes you want to check a link is active depending on the request URL, the query string or the current route
Especially for backend sidebar.

![Bilby Stampede](http://s22.postimg.org/acwm89mf5/Selection_011.png)

Basically we do like this.
```blade
<li class="sidebar {{ Request::is('post') ? 'active' : 'no' }} ">Post</li>
<li class="sidebar {{ Request::is('page') ? 'active' : 'no' }} ">Page</li>
```
It would be nice if we can make shorter, right ?
```blade
<li class="sidebar {{ active_url_is('post') }} ">Post</li>
<li class="sidebar {{ active_url_is('page') }} ">Page</li>
```
Or, if you prefer to check the route:
```blade
<li class="sidebar {{ active_route_in('users.list') }}">Users list</li>
<li class="sidebar {{ active_route_in('groups.list') }}">Groups list</li>
```

## Installation

Install with `composer`:

### Laravel 5.5

Use the latest:

```
composer require arcesilas/active-state:^2.0
```

You're done! Service provider and Facade are automatically registered by Laravel.

If you don't want to use the Facade or want to use your own Service Provider, add this to your `composer.json`:

```json
"extra": {
    "laravel": {
        "dont-discover": [
            "arcesilas/active-state"
        ]
    }
},
```
See [Package discovery](https://laravel.com/docs/5.5/packages#package-discovery) section on Laravel documentation.

### Laravel 5.4 and before

For older versions of Laravel, please use appropriate versions of Active State:

* Laravel 5.4: v1.2
* Laravel 5.3 and below: 0.0.2

Add the service provider in `config/app.php`
```php
'providers' => [
    ........,
    Arcesilas\ActiveState\ActiveStateServiceProvider::class,
]
```

If you want to use the facade, add this to your facades in `config/app.php`

```php
'aliases' => [
    ........,
    'Active' => Arcesilas\ActiveState\ActiveFacade::class,
]

```
To publish configuration file
```
php artisan vendor:publish --provider="Arcesilas\ActiveState\ActiveStateServiceProvider"
```

## Configuration

### Active and inactive values

You can configure the _active_ and _inactive_. These values are displayed when using the if* tests on the Facade.

Defaults are:

```php
// The default  value if the request match given action
'active_state'      =>  'active',

// The default  value if the request match given action
'inactive_state'    =>  '',
```

For instance, when checking a url:
```blade
<li class="menu {{ Active::ifUrl('/home')}}">Home</li>
```
will result in:
```
<li class="menu active">Home</li>
```
if the current URL is actually `/home`.

#### Change values at runtime

To change the active_value and inactive_value, you may use respectively Active::setActiveValue() and Active::setInactiveValue().

Their signature is:

`Active::setActiveValue($value, $persistent = null)`

* $value argument is the value to assign
* $persistent is optional:
    * If set to true, the assigned value will be set until it is reset.
    * If set to false, the assigned value will be used for the next check then it will be reset
    * If set to null, the persistency it not changed

### Blade directives

The package provides with blade directive to make your life easier. Their names are fully customizable, in the `blade` section of the `active.php` configuration file.

For instance, if you do not want to use `@url_is` and prefer `@check_url`, just set this name in the `active.php` configuration file:

```php
return [
    // ...
    'blade' => [
        // Current URL IS xxxx
        'url_is'           => 'check_url',
    ]
```

All the directives are listed in the configuration file.

## Usage

There are 2 kinds of tests: `if*` and `check*`.

* `check*` tests return a boolean, and can be used in any `if` loop
* `if*` tests return the active or inactive value. They simply translate the if* equivalent test into a string usable as a css class.

Quick example:

```html
<li class="menu-item {{ Active::ifUrl('foo/bar') }}">Foo: Bar</li>
```
will render:
```html
<li class="menu-item active">Foo: Bar</li>
```

All the following examples will show only `check*` tests. They all have their `if*` equivalent:
`checkRoute()` will return a boolean and `ifRoute()` will return the active or inactive value depending on `checkRoute()` test result.

This documentation file uses th Facade in all examples. You may use the container instance, instead of the Facade:

```
Active::checkRouteIn('users.list');
// is equivalent to:
$app['active-state']->checkRouteIn('users.list');
// or
app('active-state')->checkRouteIn('users.list');
```

### URL checks

You can make several checks against the current request URL:

#### Check URL is exactly a value

To check if the URL is exactly the given value:

With URL `http://example.com/foo/bar`:
```php
Active::checkUrl('foo/bar') // true
```
you can use wildcards:
```php
Active::checkUrl('foo/*') // true
```

You can also check multiple urls, and mix with wildcards.

With URL `http://example.com/news/2017/11/some-article-slug`:
```php
Active::checkUrl('news/*', 'article/*') // true
```

#### Check URL contains a string

To check the URL contains a string, regardless its position in the URL string:

With URL `http://example.com/news/2017/11/some-article-slug`
```php
Active::checkUrlHas('2017') // true
``

Once again, you can pass more than one string to search:

With url: `http://example.com/news/2016/some-article-slug`
```php
Active::checkUrlHas('2017', '2018', 'article') // true
```

Note that while it's possible to use wildcards here, it does not really make sense, since the following examples are strictly equivalent:
```php
Active::checkUrl('*something*')
Active::checkUrlHas('something')
```

### Route checks

#### Check route name and parameters

You can check that the current route is a given route name and that the parameters have a given value.

It is similar to URL checking, except that this test will build the URL with the route definition and the given parameters (using `route()` helper).
If you ever change the route URI, your test will not need to be changed.

Example for a route defined like this:
```php
Route::get('/articles/category/{slug}', 'CategoryController@show')->name('category.show');
```
Check the URL with the route this way:
```php
Active::checkRoute('category.show', ['slug' => $currentCategory->slug)
```

This is especially useful when you display a list of links that all lead to the same route with only a slug or id which differ.

#### Check route name only

You don't necessarily need to give parameters to check the current route. If all your links lead to different routes, you don't care of the paremeters.

You can do it using `checkRouteIn` test:

With current route name `user.dashboard`:
```php
Active::checkRouteIn('my.profile', 'user.dashboard')
```
You may only provide one route name, or as many as you need.

### Query checks

#### Check query parameters are exactly the ones you check

You may check that the exact parameters you require are present in the URL (name and value).

with url: http://example.com/foo/bar?param1=value1&param3=value3
```php
Active::checkQuery(['param1' => 'value1', 'param3' => 'value3']) // true
Active::checkQuery(['param1' => 'value1']) // false, because the query has param3 which is not specified
Active::checkQuery(['param1' => 'value1', 'param2' => 'value2']) // false because param2 is not present in the query string
```

You can also check with more than one set of parameters:

with url: http://example.com/foo/bar?param1=value1&param3=value3
```php
Active::checkQuery(['param2' => 'value2'], ['param1' => 'value1']) // True, because the second set matches with param1 => value1
```

#### Check parameters are present in the query string

You can check one or more parameters are present in the query string (without taking their values into account):

with url: http://example.com/foo/bar?param1=value1&something=42&hello=world
```
Active::checkQueryHas('param1') // true
Active::checkQueryHas('param1', 'hello') // true
Active::checkQueryHas('param1', 'param2') // false
```

#### Check query string has only the given parameters

You can check that the parameters of the query are exactly the ones you require. Only their names are checked.

With url: http://example.com/foo/bar?param1=value1&hello=world
```php
Active::checkQueryHasOnly('param1', 'hello') // true
Active::checkQueryHasOnly('param1') // false: the query also has hello
Active::checkQueryHasOnly('param1', 'hello', 'foo') // false: the query does not have foo
```

#### Check query parameters are contained in the query

This check is a combination of `checkQuery` and `checkQueryHas`: the check is successfull if the parameters you check are strictly contained in the query (names and values). But you don't care of their order:

With url: http://example.com/foo/bar?param1=value1&hello=world
```php
Active::checkUrlContains(['param1' => 'value1']) // true
Active::checkUrlContains(['param1' => 'random']) // false: query contains param1, but with value value1, not random
Active::checkUrlContains(['hello' => 'world', 'param1' => 'value2']) // true
```

### Blade directives

The following _if_ Blade directives are defined by default for their equivalent checks:

* `@url_is()`: `checkUrl()`
* `@url_has()`: `checkUrlHas()`
* `@route_is()`: `checkRoute()`
* `@route_in()`: `checkRouteIn()`
* `@route_has()`: `checkRouteHas()`
* `@query_is()`: `checkQuery()`
* `@query_has()`: `checkQueryHas()`
* `@query_has_only()`: `checkHasOnly()`
* `@query_contains()`: `checkQueryContains()`

All these directives have their opposites. Just append "_not" to the directive.

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
@route_is_not('user.show')
    // The route is NOT user.show
@endroute_is_not
```

The directives simply replace Active::check* calls, which can obviously be used instead, if you prefer.

> **Note**: If you change the Blade directives configuration, you need to clear the compiled views:
> ``` shell
> php artisan view:clear
> ```

### Helpers

Some helpers are available for all Active check methods:

* `active_url_is()`
* `active_url_has()`
* `active_route_is()`
* `active_route_in()`
* `active_query_is()`
* `active_query_has()`
* `active_query_has_only()`
* `active_query_contains()`

They take the same arguments than the Active::if* methods and return their equivalent if* check result.

## Additional features

### Get state

`Active::getState($boolean)` allows you to get the active_value or inactive value for the boolean passed in argument.

### Get values

`Active::getActiveValue()` and `Active::getInactiveValue()` are available at any time to get the value for respectively Active and Inactive states.

### Reset values

You can reset Active and Inactive values to configuration defaults with `Active::resetValues()`
