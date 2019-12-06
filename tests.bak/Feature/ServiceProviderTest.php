<?php

namespace Arcesilas\ActiveState\Tests\Feature;

use Illuminate\Support\Facades\Blade;
use PHPUnit\Framework\TestCase;
use Arcesilas\ActiveState\Active;
use Arcesilas\ActiveState\ActiveStateServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\View\ViewServiceProvider;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Filesystem\FilesystemServiceProvider;
use Illuminate\Config\Repository as ConfigRepository;

class ServiceProviderTest extends TestCase
{
    protected $directives;

    public function setUp()
    {
        $app = new Application(__DIR__);

        Blade::setFacadeApplication($app);

        $app->singleton('files', function () {
            return new Filesystem;
        });

        $app->register(FilesystemServiceProvider::class);

        $app['blade.compiler'] = new \Illuminate\View\Compilers\BladeCompiler(
            $this->prophesize(\Illuminate\Filesystem\Filesystem::class)->reveal(),
            // $app['files'],
            sys_get_temp_dir()
        );

        // $app['config'] = $this->createMock(ConfigRepository::class);
        $app['config'] = new ConfigRepository;
        $app['config']['view.compiled'] = sys_get_temp_dir();
        $app['config']['view.paths'] = [__DIR__.'/stubs'];

        $app->register(ViewServiceProvider::class);

        $activeSP = new Mocks\ActiveStateServiceProviderMock($app);
        $app->register($activeSP);
        $activeSP->boot();

        $this->directives = array_keys($app['blade.compiler']->getCustomDirectives());
    }

    public function directivesProvider()
    {
        return [
            ['path_is'],
            ['not_path_is'],
            ['path_has'],
            ['not_path_has'],
            ['route_is'],
            ['not_route_is'],
            ['route_in'],
            ['not_route_in'],
            ['query_is'],
            ['not_query_is'],
            ['query_has'],
            ['not_query_has'],
            ['query_has_only'],
            ['not_query_has_only'],
            ['query_contains'],
            ['not_query_contains']
        ];
    }

    /**
     * @dataProvider directivesProvider
     * @coversNothing
     */
    public function testActiveStateServiceProvider($directive)
    {
        $elseDirective = 'else'.$directive;
        $endDirective = 'end'.$directive;

        $this->assertContains($directive, $this->directives);
        $this->assertContains($elseDirective, $this->directives);
        $this->assertContains($endDirective, $this->directives);
    }
}
