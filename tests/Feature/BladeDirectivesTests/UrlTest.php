<?php

namespace Arcesilas\ActiveState\Tests\Feature\BladeDirectivesTests;

use Illuminate\Foundation\Application;
use Illuminate\Http\Request as HttpRequest;
use Arcesilas\ActiveState\ActiveFacade as Active;

class UrlTest extends BladeDirectivesTestCase
{
    public function setUp()
    {
        $this->app = new Application(__DIR__);

        $this->initBlade();
        $this->loadActiveStateServiceProvider();

        if (!class_exists('Active')) {
            class_alias(Active::class, 'Active');
        }
    }

    /**
     * @dataProvider Arcesilas\ActiveState\Tests\DataProviders\PathIs::getData()
     */
    public function testUrlIs($expected, $testUrl)
    {
        $this->app['request'] = HttpRequest::create('http://example.com/foo/bar');
        $this->assertEquals(
            $this->expected($expected),
            @view('url_is', ['testUrl' => $testUrl])->render()
        );

        $this->assertEquals(
            @view('path_is', ['testPath' => $testUrl])->render(),
            @view('url_is', ['testUrl' => $testUrl])->render()
        );
    }

    /**
     * @dataProvider Arcesilas\ActiveState\Tests\DataProviders\PathIs::getData()
     */
    public function testNotUrlIs($expected, $testUrl)
    {
        $this->app['request'] = HttpRequest::create('http://example.com/foo/bar');
        $this->assertEquals(
            $this->expected(! $expected),
            @view('not_url_is', ['testUrl' => $testUrl])->render()
        );
        $this->assertEquals(
            @view('not_path_is', ['testPath' => $testUrl])->render(),
            @view('not_url_is', ['testUrl' => $testUrl])->render()
        );
    }

    /**
     * @dataProvider Arcesilas\ActiveState\Tests\DataProviders\PathHas::getData()
     */
    public function testUrlHas($expected, $testUrl)
    {
        $this->app['request'] = HttpRequest::create('http://example.com/foo/bar');
        $this->assertEquals(
            $this->expected($expected),
            @view('url_has', ['testUrl' => $testUrl])->render()
        );
        $this->assertEquals(
            @view('path_has', ['testPath' => $testUrl])->render(),
            @view('url_has', ['testUrl' => $testUrl])->render()
        );
    }

    /**
    * @dataProvider Arcesilas\ActiveState\Tests\DataProviders\PathHas::getData()
     */
    public function testNotUrlHas($expected, $testUrl)
    {
        $this->app['request'] = HttpRequest::create('http://example.com/foo/bar');
        $this->assertEquals(
            $this->expected(! $expected),
            @view('not_url_has', ['testUrl' => $testUrl])->render()
        );
        $this->assertEquals(
            @view('not_path_has', ['testPath' => $testUrl])->render(),
            @view('not_url_has', ['testUrl' => $testUrl])->render()
        );
    }
}
