<?php

declare(strict_types=1);

namespace Arcesilas\ActiveState\Tests\Unit\Active;

use Arcesilas\ActiveState\Tests\TestCase;
use Arcesilas\ActiveState\Active;
use Illuminate\Http\Request as HttpRequest;

/** @coversDefaultClass Arcesilas\ActiveState\Active */
class CheckQueryTest extends TestCase
{
    protected $active;

    public function init($requestUrl): void
    {
        $request = HttpRequest::create('http://example.com'.$requestUrl);
        $this->active = new Active($request);
    }

    /**
     * @dataProvider queryIsProvider
     * @covers ::checkQueryIs
     */
    public function testCheckQueryIs($requestUrl, $expected, array $params)
    {
        $this->init($requestUrl);
        $this->assertSame($expected, $this->active->checkQueryIs(...$params));
    }

    /**
     * @dataProvider queryHasProvider
     * @covers ::checkQueryHas
     */
    public function testCheckQueryHas($requestUrl, $expected, array $params)
    {
        $this->init($requestUrl);
        $this->assertSame($expected, $this->active->checkQueryHas(...$params));
    }

    /**
     * @dataProvider queryHasOnlyProvider
     * @covers ::checkQueryHasOnly
     */
    public function testCheckQueryHasOnly($requestUrl, $expected, array $params)
    {
        $this->init($requestUrl);
        $this->assertSame($expected, $this->active->checkQueryHasOnly(...$params));
    }

    /**
     * @dataProvider queryContainsProvider
     * @covers ::checkQueryContains
     */
    public function testCheckQueryContains($requestUrl, $expected, $params)
    {
        $this->init($requestUrl);
        $this->assertSame($expected, $this->active->checkQueryContains($params));
    }

    /**
     * @dataProvider queryIsProvider
     * @covers ::__call
     * @covers ::checkQueryIs
     */
    public function testCheckNotQueryIs($requestUrl, $expected, array $params)
    {
        $this->init($requestUrl);
        $this->assertSame(! $expected, $this->active->checkNotQueryIs(...$params));
    }

    /**
     * @dataProvider queryHasProvider
     * @covers ::__call
     * @covers ::checkQueryHas
     */
    public function testCheckNotQueryHas($requestUrl, $expected, array $params)
    {
        $this->init($requestUrl);
        $this->assertSame(! $expected, $this->active->checkNotQueryHas(...$params));
    }

    /**
     * @dataProvider queryHasOnlyProvider
     * @covers ::__call
     * @covers ::checkQueryHasOnly
     */
    public function testCheckNotQueryHasOnly($requestUrl, $expected, array $params)
    {
        $this->init($requestUrl);
        $this->assertSame(! $expected, $this->active->checkNotQueryHasOnly(...$params));
    }

    /**
     * @dataProvider queryContainsProvider
     * @covers ::__call
     * @covers ::checkQueryContains
     */
    public function testCheckNotQueryContains($requestUrl, $expected, $params)
    {
        $this->init($requestUrl);
        $this->assertSame(! $expected, $this->active->checkNotQueryContains($params));
    }

    public function queryContainsProvider()
    {
        return [
            ['foo/bar', true, []],
            ['foo/bar?arg1=val1&arg3=val3&arg2=val2', true, [
                'arg3' => 'val3', 'arg1' => 'val1'
            ]],
            ['foo/bar?arg1=val1&arg3=val3', false, [
                'arg1' => 'val1', 'arg2' => 'val2'
            ]],
            ['foo/bar?arg1=val1', false, [
                'arg1' => 'val2'
            ]]
        ];
    }

    public function queryHasProvider()
    {
        // [$requestUrl, $expected, array $params]
        return [
            ['foo/bar?arg1=val1&arg2=val2', true, ['arg1']],
            ['foo/bar?arg1=val1&arg2=val2', true, ['arg1', 'arg2']],
            ['foo/bar?arg1=val1&arg2=val2', true, ['arg2', 'arg1']],
            ['foo/bar?arg1=val1&arg2=val2', false, ['arg3']],
            ['foo/bar?arg1=val1&arg2=val2', false, ['arg1', 'arg3']],
            ['foo/bar', false, ['arg1']],
            ['foo/bar?', false, ['arg1']],
            ['foo/bar', true, []],
            ['foo/bar?', true, []]
        ];
    }

    public function queryHasOnlyProvider()
    {
        // [$requestUrl, $expected, array $params]
        return [
            ['foo/bar', true, []],
            ['foo/bar?arg1=val1', true, ['arg1']],
            ['foo/bar?arg2=val2&arg1=val1', true, ['arg1', 'arg2']],
            ['foo/bar?arg2=val2&arg1=val1', false, ['arg1']],
            ['foo/bar?arg2=val2', false, ['arg3', 'arg2']]
        ];
    }

    public function queryIsProvider()
    {
        // [$requestUrl, $expected, array $params]
        return [
            // Parameters arrays have to be passed in array
            ['foo/bar', true, [
                // One empty parameter array
                []
            ]],
            ['foo/bar?arg1=val1&arg2=val2', true, [
                // One parameter array
                ['arg1' => 'val1', 'arg2' => 'val2']
            ]],
            ['foo/bar?arg1=val1&arg2=val2', false, [
                // One parameter array
                ['arg1' => 'val1']
            ]],
            ['foo/bar?arg1=val1', true,[
                ['arg1' => 'val1']
            ]],
            ['foo/bar?arg1=val1', false, [
                ['arg1' => 'val1', 'arg2' => 'val3']
            ]],
            ['foo/bar?arg1=val1', false, [
                // One parameter array
                ['arg1' => 'val2']
            ]],
            ['foo/bar?arg1=val1', false, [
                // One parameter array
                ['arg2' => 'val1']
            ]],
            ['foo/bar?arg1=val1', true, [
                // Multiple parameter arrays
                ['arg1' => 'val2'],
                ['arg1' => 'val1'] // This is the one that will match the query parameters
            ]],
            ['foo/bar?arg1=val1&arg2=val2', true, [
                // Multiple parameter arrays
                ['arg1' => 'val2'],
                ['arg1' => 'val1'],
                ['arg1' => 'val1', 'arg2' => 'val2'] // This is the one that will match the query parameters
            ]],
            // The order must not matter
            ['foo/bar?arg2=val2&arg1=val1', true, [
                ['arg1' => 'val1', 'arg2' => 'val2']
            ]]
        ];
    }
}
