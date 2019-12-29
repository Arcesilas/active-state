# Active State

[![Packagist](https://img.shields.io/packagist/v/Arcesilas/active-state.svg?label=Packagist&style=flat-square)](https://packagist.org/packages/arcesilas/active-state)
[![license](https://img.shields.io/github/license/Arcesilas/active-state.svg?style=flat-square)](https://github.com/Arcesilas/active-state)
[![Travis](https://img.shields.io/travis/Arcesilas/active-state.svg?style=flat-square)](https://travis-ci.org/Arcesilas/active-state)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/Arcesilas/active-state.svg?style=flat-square)](https://scrutinizer-ci.com/g/Arcesilas/active-state/)

This package helps you check if a given link matches the current URL, route or query string. This is especially useful in sidebars.

> **History**  
> This package was originally a fork from [pyaesone17/active-state](https://github.com/pyaesone17/active-state). To fix [issue #8](https://github.com/pyaesone17/active-state/issues/8), I rewrote entirely the package.

Basically you would do like this:
```blade
<li class="sidebar {{ Request::is('post') ? 'active' : 'no' }} ">Post</li>
<li class="sidebar {{ Request::is('page') ? 'active' : 'no' }} ">Page</li>
```
With this package, you can make it shorter:
```blade
<li class="sidebar {{ active_path_is('post') }} ">Post</li>
<li class="sidebar {{ active_path_is('page') }} ">Page</li>
```
Or, if you prefer to check the route:
```blade
<li class="sidebar {{ active_route_in('users.list') }}">Users list</li>
<li class="sidebar {{ active_route_in('groups.list') }}">Groups list</li>
```

Keywords: route, url, query, menu, link, request, laravel, active

## TL;DR

Maybe you just need the [cheatsheet](docs/cheatsheet.md)?

## Table of contents

0. [Quickstart](#quickstart)
1. [Installation](docs/installation.md)
2. [Upgrade from v2.x to v3.x](docs/upgrade.md)
3. [Usage](docs/usage.md)
    * [Path checks](docs/usage.md#path-checks)
    * [Route checks](docs/usage.md#route-checks)
    * [Query string checks](docs/usage.md#query-checks)
4. [Blade directives](docs/blade-directives.md)
5. [Additional features](docs/tools.md)
    * [Helpers](docs/tools.md#helpers)
    * [Additional features](docs/tools.md#additional-features)
6. [Cheatsheet](docs/cheatsheet.md)

## Quickstart

### Install with Composer
```shell
composer require arcesilas/active-state:^4.0
```

Version 4 is currently in alpha version. If your configuration requires higher than alpha, make sure to specify the full version:

```shell
composer require arcesilas/active-state:^4.0.0-alpha
```

If you want the latest release:

```shell
composer require arcesilas/active-state:@dev-develop-v4
```

### Use it in your views

Check current path is `foo/bar`:
```blade
<li class="menu-item {{ Active::ifPathIs('foo/bar') }}">Foo: Bar</li>
```

will render:

```html
<li class="menu-item active">Foo: Bar</li>
```
if the current path is actually `foo/bar`.

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
<a class="nav-link {{Active::ifUrlContains(['slug' => $category->slug])}}" href="{{ route('videos.category', $category->slug) }}">
```
