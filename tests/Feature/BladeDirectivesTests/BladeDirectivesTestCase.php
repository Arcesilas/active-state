<?php

namespace Arcesilas\ActiveState\Tests\Feature\BladeDirectivesTests;

use Illuminate\Support\Facades\Blade;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\ViewServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Arcesilas\ActiveState\Tests\Feature\Mocks;
use Arcesilas\ActiveState\Tests\ActiveTestCase;
use Illuminate\Config\Repository as ConfigRepository;

abstract class BladeDirectivesTestCase extends ActiveTestCase
{

    protected $app;

    protected function initBlade()
    {
        Blade::setFacadeApplication($this->app);

        $this->app->singleton('files', function () {
            return new Filesystem;
        });

        $this->app['blade.compiler'] = new BladeCompiler(
            $this->app['files'],
            sys_get_temp_dir()
        );

        $this->app['config'] = new ConfigRepository();
        $this->app['config']['view.compiled'] = sys_get_temp_dir();
        $this->app['config']['view.paths'] = [__DIR__.'/../stubs'];

        $this->app->register(ViewServiceProvider::class);
    }

    protected function loadActiveStateServiceProvider()
    {
        $activeSP = new Mocks\ActiveStateServiceProviderMock($this->app);
        $this->app->register($activeSP);
        $activeSP->boot();
    }
}
