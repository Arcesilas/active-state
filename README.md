# Active State

This package helps you check if a given link matches the current URL, route or query string. This is especially useful in sidebars.

> **History**  
> This package was originally a fork from [pyaesone17/active-state](https://github.com/pyaesone17/active-state). To fix [issue #8](https://github.com/pyaesone17/active-state/issues/8), I rewrote entirely the package.

![Example](http://s22.postimg.org/acwm89mf5/Selection_011.png)

Basically you would do like this:
```blade
<li class="sidebar {{ Request::is('post') ? 'active' : 'no' }} ">Post</li>
<li class="sidebar {{ Request::is('page') ? 'active' : 'no' }} ">Page</li>
```
With this package, you can make it shorter:
```blade
<li class="sidebar {{ active_url_is('post') }} ">Post</li>
<li class="sidebar {{ active_url_is('page') }} ">Page</li>
```
Or, if you prefer to check the route:
```blade
<li class="sidebar {{ active_route_in('users.list') }}">Users list</li>
<li class="sidebar {{ active_route_in('groups.list') }}">Groups list</li>
```

Keywords: route, url, query, menu, link, request, laravel, active

## TL;DR

Maybe you just need the [cheatsheet](doc/cheatsheet.md)?

## Table of contents

0. [Quickstart](#quickstart)
1. [Installation](doc/installation.md)
2. [Usage](doc/usage.md)
    * [URL checks](doc/usage.md#url-checks)
    * [Route checks](doc/usage.md#route-checks)
    * [Query string checks](doc/usage.md#query-checks)
2. [Blade directives](doc/blade-directives.md)
3. [Additional features](doc/tools.md)
    * [Helpers](doc/tools.md#helpers)
    * [Additional features](doc/tools.md#additional-features)
4. [Cheatsheet](doc/cheatsheet.md)

## Quickstart

### Install with Composer
```shell
composer require arcesilas/active-state:^2.0
```

### Use it in your views

Check current URL is `foo/bar`:
```blade
<li class="menu-item {{ Active::ifUrlIs('foo/bar') }}">Foo: Bar</li>
```

will render:

```html
<li class="menu-item active">Foo: Bar</li>
```
if the current URL is actually `foo/bar`.

Check route name is `posts`:

```blade
<a class="nav-link {{ Active::ifRouteIn('posts') }}" href="{{ route('posts') }}">
```

Check route name is `posts` and `slug` parameter is a given value:

```blade
<a class="nav-link {{Active::ifRouteIs('posts.category', ['slug' => $category->slug])}}" href="{{ route('posts.category', $category->slug) }}">
```

Check query string contains argument `foo` with value `bar`:

```blade
<a class="nav-link {{Active::ifQueryHas('videos.category', ['slug' => $category->slug])}}" href="{{ route('videos.category', $category->slug) }}">
```
