# ActiveState checks

All the following examples will show only `check*` tests. They all have their `if*` equivalent:
`checkRouteIs()` will return a boolean and `ifRouteIs()` will return the active or inactive value depending on `checkRouteIs()` test result.

This documentation file uses the Facade in all examples. You may use the container instance, instead of the Facade:

```
Active::checkRouteIn('users.list');
// is equivalent to:
$app['active-state']->checkRouteIn('users.list');
// or
app('active-state')->checkRouteIn('users.list');
```

## URL checks

You can make several checks against the current request URL:

### Check URL is exactly a value

To check if the URL is exactly the given value:

With URL `http://example.com/foo/bar`:
```php
Active::checkUrlIs('foo/bar') // true
```
you can use wildcards:
```php
Active::checkUrlIs('foo/*') // true
```

You can also check multiple urls, and mix with wildcards.

With URL `http://example.com/news/2017/11/some-article-slug`:
```php
Active::checkUrl('news/*', 'article/*') // true
```

### Check URL contains a string

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
Active::checkUrlIs('*something*')
Active::checkUrlHas('something')
```

## Route checks

### Check route name and parameters

You can check that the current route is a given route name and that the parameters have a given value.

It is similar to URL checking, except that this test will build the URL with the route definition and the given parameters (using `route()` helper).
If you ever change the route URI, your test will not need to be changed.

Example for a route defined like this:
```php
Route::get('/articles/category/{slug}', 'CategoryController@show')->name('category.show');
```
Check the URL with the route this way:
```php
Active::checkRouteIs('category.show', ['slug' => $currentCategory->slug)
```

This is especially useful when you display a list of links that all lead to the same route with only a slug or id which differ.

### Check route name only

You don't necessarily need to give parameters to check the current route. If all your links lead to different routes, you don't care of the paremeters.

You can do it using `checkRouteIn` test:

With current route name `user.dashboard`:
```php
Active::checkRouteIn('my.profile', 'user.dashboard') // true, `user.dashboard` matches the current route name
```
You may only provide one route name, or as many as you need.

## Query checks

### Check query parameters are exactly the ones you check

You may check that the exact parameters you require are present in the URL (name and value).

with url: http://example.com/foo/bar?param1=value1&param3=value3
```php
Active::checkQueryIs(['param1' => 'value1', 'param3' => 'value3']) // true
Active::checkQueryIs(['param1' => 'value1']) // false, because the query has `param3` which is not specified
Active::checkQueryIs(['param1' => 'value1', 'param2' => 'value2']) // false because `param2` is not present in the query string
```

You can also check with more than one set of parameters:

with url: http://example.com/foo/bar?param1=value1&param3=value3
```php
Active::checkQueryIs(['param2' => 'value2'], ['param1' => 'value1']) // True, because the second set matches with `param1 => value1`
```

### Check parameters are present in the query string

You can check one or more parameters are present in the query string (without taking their values into account):

with url: http://example.com/foo/bar?param1=value1&something=42&hello=world
```
Active::checkQueryHas('param1') // true
Active::checkQueryHas('param1', 'hello') // true
Active::checkQueryHas('param1', 'param2') // false
```

### Check query string has only the given parameters

You can check that the parameters of the query are exactly the ones you require. Only their names are checked.

With url: http://example.com/foo/bar?param1=value1&hello=world
```php
Active::checkQueryHasOnly('param1', 'hello') // true
Active::checkQueryHasOnly('param1') // false: the query also has hello
Active::checkQueryHasOnly('param1', 'hello', 'foo') // false: the query does not have `foo`
```

### Check query parameters are contained in the query

This check is a combination of `checkQuery` and `checkQueryHas`: the check is successfull if the parameters you check are strictly contained in the query (names and values). But you don't care of their order:

With url: http://example.com/foo/bar?param1=value1&hello=world
```php
Active::checkUrlContains(['param1' => 'value1']) // true
Active::checkUrlContains(['param1' => 'random']) // false: query contains `param1`, but with value `value1`, not random
Active::checkUrlContains(['hello' => 'world', 'param1' => 'value2']) // true
```

## Change the Active value for one only test

```blade
{{ Active::state('current')->ifRouteIn('foo.bar') }}
```

This is equivalent to:
```blade
{{ Active::setActiveValue('current', false); Active::ifRouteIn('foo.bar') }}
```

See the [Cheatsheet](cheatsheet.md) for a summary of all tests.
