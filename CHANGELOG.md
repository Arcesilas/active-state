# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [v4.0] - 2019-12-06
- Update to Laravel 6, drop Laravel 5
- Refactor all tests to use `orchestra/testbench`

## [v3.0] - Unreleased
### Deprecated
- `Active` methods:
    - `Active::checkUrlHas()`
    - `Active::checkUrlIs()`
    - `Active::ifUrlHas()`
    - `Active::ifUrlIs()`

- Blade directives:
    - `@not_url_has`
    - `@not_url_is`
    - `@url_has`
    - `@url_is`

- Helpers:
    - `active_url_has()`
    - `active_url_is()`

### Added
- Active methods:
    - Active::checkPathHas() as a replacement for Active::checkUrlHas()
    - Active::checkPathIs() as a replacement for Active::checkUrlIs()
    - Active::ifPathHas() as a replacement for Active::ifUrlHas()
    - Active::ifPathIs() as a replacement for Active::ifUrlIs()
    - Active::checkNotPathHas()
    - Active::checkNotPathIs()
    - Active::checkNotRouteIn()
    - Active::checkNotRouteIs()
    - Active::checkNotQueryContains()
    - Active::checkNotQueryHas()
    - Active::checkNotQueryHasOnly()
    - Active::checkNotQueryIs()
    - Active::ifNotPathHas()
    - Active::ifNotPathIs()
    - Active::ifNotRouteIn()
    - Active::ifNotRouteIs()
    - Active::ifNotQueryContains()
    - Active::ifNotQueryHas()
    - Active::ifNotQueryHasOnly()
    - Active::ifNotQueryIs()

- Helpers
    - active_path_has() as a replacement for active_url_has()
    - active_path_is() as a replacement for active_url_is()
    - active_not_path_has()
    - active_not_path_is()
    - active_not_route_in()
    - active_not_route_is()
    - active_not_query_contains()
    - active_not_query_has()
    - active_not_query_has_only()
    - active_not_query_is()

## [2.1.0] - 2018-05-10

### Added
- Active::state() method, to change the Active value for one test only

## [2.0.3] - 2018-01-24

### Fixed
- Documentation has been rewritten

## [2.0.2] - 2018-01-17

### Fixed
- Typo in readme

## [2.0.1] - 2017-11-24

### Added
- Details about installation
- Keyword in composer.json

### Fixed
- Typo in Readme

## [2.0.0] - 2017-11-15

### Changed
- Forked and detached repository from pyaesone17/active-state
- Changed namespace
- Require Laravel/Framework ^5.5
- Coding Style: PSR-1 & PSR-2 compliant
- All checks (code has been entirely rewritten)
- Blade directives names can be configured
- Capitalized README.md filename for consistency with changelog and license files

### Added
- Author: Olivier Cecillon
- Unit and Feature tests
- More blade directives
- More helpers
- Changelog file
