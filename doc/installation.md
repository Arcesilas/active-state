# ActiveState installation

## Laravel 5.5

Use the latest:

```shell
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

Read how to [configure](configuration.md) the package.

## Laravel 5.4 and before

For older versions of Laravel, please use appropriate versions of Active State:

* Laravel 5.4: v1.2.x

    ```shell
    composer require arcesilas/active-state:^1.2
    ```

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

Read how to [configure](configuration.md) the package.
