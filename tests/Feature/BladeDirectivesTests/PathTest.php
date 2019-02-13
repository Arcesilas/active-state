<?php

namespace Arcesilas\ActiveState\Tests\Feature\BladeDirectivesTests;

use Illuminate\Foundation\Application;
use Illuminate\Http\Request as HttpRequest;
use Arcesilas\ActiveState\ActiveFacade as Active;

class PathTest extends BladeDirectivesTestCase
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
    public function testPathIs($expected, $testPath)
    {
        $this->app['request'] = HttpRequest::create('http://example.com/foo/bar');
        $this->assertEquals(
            $this->expected($expected),
            view('path_is', ['testPath' => $testPath])->render()
        );
    }

    /**
     * @dataProvider Arcesilas\ActiveState\Tests\DataProviders\PathIs::getData()
     */
    public function testNotPathIs($expected, $testPath)
    {
        $this->app['request'] = HttpRequest::create('http://example.com/foo/bar');
        $this->assertEquals(
            $this->expected(! $expected),
            view('not_path_is', ['testPath' => $testPath])->render()
        );
    }

    /**
     * @dataProvider Arcesilas\ActiveState\Tests\DataProviders\PathHas::getData()
     */
    public function testPathHas($expected, $testPath)
    {
        $this->app['request'] = HttpRequest::create('http://example.com/foo/bar');
        $this->assertEquals(
            $this->expected($expected),
            view('path_has', ['testPath' => $testPath])->render()
        );
    }

    /**
    * @dataProvider Arcesilas\ActiveState\Tests\DataProviders\PathHas::getData()
     */
    public function testNotPathHas($expected, $testPath)
    {
        $this->app['request'] = HttpRequest::create('http://example.com/foo/bar');
        $this->assertEquals(
            $this->expected(! $expected),
            view('not_path_has', ['testPath' => $testPath])->render()
        );
    }
}
