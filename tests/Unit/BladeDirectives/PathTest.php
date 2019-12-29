<?php

declare(strict_types=1);

namespace Arcesilas\ActiveState\Tests\Unit\BladeDirectives;

use Arcesilas\ActiveState\Tests\TestCase;
use Illuminate\Http\Request as HttpRequest;

class PathTest extends BladeDirectivesTestCase
{
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);
        $app['request'] = HttpRequest::create('http://example.com/foo/bar');
    }

    /** @dataProvider Arcesilas\ActiveState\Tests\Unit\Active\CheckPathTest::pathHasProvider*/
    public function testPathHasDirective($expected, $testPath)
    {
        $this->assertSame(
            $this->expected($expected),
            view('path_has', ['testPath' => $testPath])->render()
        );
    }

    /** @dataProvider Arcesilas\ActiveState\Tests\Unit\Active\CheckPathTest::pathHasProvider*/
    public function testNotPathHasDirective($expected, $testPath)
    {
        $this->assertSame(
            $this->expected(! $expected),
            view('not_path_has', ['testPath' => $testPath])->render()
        );
    }

    /** @dataProvider Arcesilas\ActiveState\Tests\Unit\Active\CheckPathTest::pathIsProvider*/
    public function testPathIsDirective($expected, $testPath)
    {
        $this->assertSame(
            $this->expected($expected),
            view('path_is', ['testPath' => $testPath])->render()
        );
    }

    /** @dataProvider Arcesilas\ActiveState\Tests\Unit\Active\CheckPathTest::pathIsProvider*/
    public function testNotPathIsDirective($expected, $testPath)
    {
        $this->assertSame(
            $this->expected(! $expected),
            view('not_path_is', ['testPath' => $testPath])->render()
        );
    }
}
