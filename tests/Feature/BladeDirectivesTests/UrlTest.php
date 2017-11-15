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
     * @dataProvider Arcesilas\ActiveState\Tests\DataProviders\UrlIs::getData()
     */
    public function testUrlIs($expected, $testUrl)
    {
        $this->app['request'] = HttpRequest::create('http://example.com/foo/bar');
        $this->assertEquals(
            $this->expected($expected),
            view('url_is', ['testUrl' => $testUrl])->render()
        );
    }

    /**
     * @dataProvider Arcesilas\ActiveState\Tests\DataProviders\UrlIs::getData()
     */
    public function testNotUrlIs($expected, $testUrl)
    {
        $this->app['request'] = HttpRequest::create('http://example.com/foo/bar');
        $this->assertEquals(
            $this->expected(! $expected),
            view('not_url_is', ['testUrl' => $testUrl])->render()
        );
    }

    /**
     * @dataProvider Arcesilas\ActiveState\Tests\DataProviders\UrlHas::getData()
     */
    public function testUrlHas($expected, $testUrl)
    {
        $this->app['request'] = HttpRequest::create('http://example.com/foo/bar');
        $this->assertEquals(
            $this->expected($expected),
            view('url_has', ['testUrl' => $testUrl])->render()
        );
    }

    /**
    * @dataProvider Arcesilas\ActiveState\Tests\DataProviders\UrlHas::getData()
     */
    public function testNotUrlHas($expected, $testUrl)
    {
        $this->app['request'] = HttpRequest::create('http://example.com/foo/bar');
        $this->assertEquals(
            $this->expected(! $expected),
            view('not_url_has', ['testUrl' => $testUrl])->render()
        );
    }
}
