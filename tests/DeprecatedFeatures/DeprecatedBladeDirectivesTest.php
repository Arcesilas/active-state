<?php

declare(strict_types=1);

namespace Arcesilas\ActiveState\Tests\Unit\BladeDirectives;

use Arcesilas\ActiveState\Tests\Unit\BladeDirectives\BladeDirectivesTestCase;
use Illuminate\Http\Request as HttpRequest;

class DeprecatedBladeDirectivesTest extends BladeDirectivesTestCase
{
    protected function getEnvironmentSetUp($app)
    {
        app('view')->addLocation(__DIR__.'/views');
        $app['request'] = HttpRequest::create('http://example.com/foo/bar');
    }

    /** @dataProvider Arcesilas\ActiveState\Tests\Unit\Active\CheckPathTest::pathHasProvider */
    public function testDeprecatedDirectiveUrlHas($expected, $testPath)
    {
        $this->assertSame(
            $this->expected($expected),
            view('url_has', ['testUrl' => $testPath])->render()
        );
    }

    /** @dataProvider Arcesilas\ActiveState\Tests\Unit\Active\CheckPathTest::pathIsProvider */
    public function testDeprecatedDirectiveUrlIs($expected, $testPath)
    {
        $this->assertSame(
            $this->expected($expected),
            view('url_is', ['testUrl' => $testPath])->render()
        );
    }

    /** @dataProvider Arcesilas\ActiveState\Tests\Unit\Active\CheckPathTest::pathHasProvider */
    public function testDeprecatedDirectiveNotUrlHas($expected, $testPath)
    {
        $this->assertSame(
            $this->expected(! $expected),
            view('not_url_has', ['testUrl' => $testPath])->render()
        );
    }

    /** @dataProvider Arcesilas\ActiveState\Tests\Unit\Active\CheckPathTest::pathIsProvider */
    public function testDeprecatedDirectiveNotUrlIs($expected, $testPath)
    {
        $this->assertSame(
            $this->expected(! $expected),
            view('not_url_is', ['testUrl' => $testPath])->render()
        );
    }
}
