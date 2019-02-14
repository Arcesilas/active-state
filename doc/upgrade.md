# Upgrade

## Upgrade from v2.x to v3.x

Version 3.0 brings some new helpers and new checks against full url.
Some methods, blade directives and helpers have been deprecated and replaced.

- `Active` methods:
    - `Active::checkUrlHas()`: use `Active::checkPathHas()` instead
    - `Active::checkUrlIs()`: use `Active::checkPathIs()` instead
    - `Active::ifUrlHas()`: use `Active::ifPathHas()` instead
    - `Active::ifUrlIs()`: use `Active::ifPathIs()` instead

- Blade directives:
    - `@not_url_has`: use `@not_path_has` instead
    - `@not_url_is`: use `@not_path_is` instead
    - `@url_has`: use `@path_has` instead
    - `@url_is`: use `@path_is` instead

    :warning: If you use custom directives, do not forget to update your configuration file accordingly.

- Helpers:
    - `active_url_has()`: use `active_path_has()` instead
    - `active_url_is()`: use `active_path_is()` instead

The deprecated methods, directives and helpers are still available for backward compatibility. They will be removed in the next major release.
