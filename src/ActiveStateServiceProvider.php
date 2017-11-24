<?php

namespace Arcesilas\ActiveState;

use Illuminate\Support\ServiceProvider;
use Blade;

class ActiveStateServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('ifActiveUrl', function ($expression) {
            return "<?php if(Active::checkBoolean($expression) ): ?>";
        });

        Blade::directive('ifActiveRoute', function ($expression) {
            return "<?php if(Active::checkRouteBoolean($expression) ): ?>";
        });

        Blade::directive('ifActiveQuery', function ($expression) {
            return "<?php if(Active::checkQueryBoolean($expression) ): ?>";
        });

        Blade::directive('endIfActiveRoute', function ($expression) {
            return '<?php endif; ?>';
        });

        Blade::directive('endIfActiveQuery', function ($expression) {
            return '<?php endif; ?>';
        });

        Blade::directive('endIfActiveUrl', function ($expression) {
            return '<?php endif; ?>';
        });

        Blade::directive('ifActiveRouteParams', function ($expression) {
            return "<?php if(Active::checkRouteParamsBoolean($expression)): ?>";
        });

        Blade::directive('endIfActiveRouteParams', function ($expression) {
            return '<?php endif; ?>';
        });

        $this->publishes([
            __DIR__.'/config/active.php' => config_path('active.php'),
        ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('active-state', function ($app) {
            return new \Arcesilas\ActiveState\Active($app->request);
        });

        $this->mergeConfigFrom(
            __DIR__.'/config/active.php',
            'active'
        );
    }
}
