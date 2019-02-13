# Upgrade

## Upgrade from v2.x to v3.x

Version 3.0 brings some new helpers and new checks against full url.

Some methods have been renamed, to better reflect reality:
- `Active::checkUrlHas()` => `Active::checkPathHas()`
- `Active::checkUrlIs()` => `Active::checkPathIs()`
- `Active::ifUrlHas()` => `Active::ifPathHas()`
- `Active::ifUrlIs()` => `Active::ifPathIs()`

Helpers have been renamed acordingly:
- `active_url_has` => `active_path_has`
- `active_url_is` => `active_path_is`

Blade directives have been renamed as well:

- `not_url_has` => `not_path_has`
- `not_url_is` => `not_path_is`
- `url_has` => `path_has`
- `url_is` => `path_is`

If you use custom directives, do not forget to update your configuration file accordingly.

Old checks, helpers and blade directives using `url` in their names are still available for backward compatibility, but are deprecated and trigger an `E_USER_DEPRECATED` error. They will be removed in the next major release.
