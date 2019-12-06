<?php

declare(strict_types=1);

namespace Arcesilas\ActiveState\Tests\Unit\Active;

use Arcesilas\ActiveState\Tests\TestCase;
use Arcesilas\ActiveState\Active;
use Illuminate\Http\Request as HttpRequest;

/**
 * @coversDefaultClass Arcesilas\ActiveState\Active
 * @covers ::__construct
 */
class CheckPathTest extends TestCase
{
    protected $active;

    public function setUp(): void
    {
        parent::setUp();
        $request = HttpRequest::create('http://example.com/foo/bar');
        $this->active = new Active($request);
    }

    /**
    * @dataProvider pathHasProvider
    * @covers ::checkPathHas
    */
    public function testCheckPathHas($expected, $testPath)
    {
        $this->assertSame($expected, $this->active->checkPathHas(...$testPath));
    }

    /**
     * @dataProvider pathIsProvider
     * @covers ::checkPathIs
     */
    public function testCheckPathIs($expected, $testPath)
    {
        $this->assertSame($expected, $this->active->checkPathIs($testPath));
    }

    /**
    * @dataProvider pathIsProvider
    * @covers ::__call
    * @covers ::checkPathIs
     */
    public function testCheckNotPathIs($expected, $testPath)
    {
        $this->assertSame(! $expected, $this->active->checkNotPathIs($testPath));
    }

    /**
    * @dataProvider pathHasProvider
    * @covers ::__call
    * @covers ::checkPathHas
     */
    public function testCheckNotPathHas($expected, $testPath)
    {
        $this->assertSame(! $expected, $this->active->checkNotPathHas(...$testPath));
    }

    public function pathHasProvider()
    {
        // [$expected, $testPath]
        return [
            [true, ['/']],
            [true, ['foo/bar']],
            [true, ['foo']],
            [true, ['bar']],
            [true, ['baz', 'bar']],
            [false, ['baz']],
        ];
    }

    public function pathIsProvider()
    {
        // [$expected, $testPath]
        return [
            [true, 'foo/bar'],
            [false, 'foo/baz'],
            [false, 'foo'],
            [true, 'fo*']
        ];
    }
}
