# Configuration

## Configuration file

The configuration files lets you customize *active* and *inactive* values, and all of the blade directives names.

You may publish the configuration file, if you need it:
```shell
php artisan vendor:publish --provider="Arcesilas\ActiveState\ActiveStateServiceProvider"
```

You don't need to define all of the configuration keys, you may provide only the ones you want to override.

### Active and Inactive

These are the values you will use as css classes in your views.

By default, the values are `'active'` and `''`:

```php
// The default  value if the request match given action
'active_state'      =>  'active',

// The default  value if the request does not match given action
'inactive_state'    =>  '',
```

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

## Configuration at runtime

The *active* and *inactive* values can be set are runtime, because you may need to use a different class for one specific link.

You can use `Active::setActiveValue()` and `Active::setInactiveValue()`. They have the same signature:

`Active::setActiveValue($value, $persistent = null)`

* `$value` argument is the value to assign
* `$persistent` is optional and defaults to null:
    * If set to true, the assigned value will be set until it is reset.
    * If set to false, the assigned value will be used for the next check then it will be reset
    * If set to null, the persistency it not changed

The values can be reset to default values (defined in the configuration file):
```php
Active::resetValues();
```
